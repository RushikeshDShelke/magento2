<?php

namespace Manish\Orderstatus\Controller\Adminhtml\Index;

class Import extends \Magento\Backend\App\Action
{
	 
/**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;
 
    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    protected $_invoiceService;
 
    /**
     * @var \Magento\Framework\DB\Transaction
     */
    protected $_transaction;
 
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\DB\Transaction $transaction
    )
	{
        $this->_orderRepository = $orderRepository;
        $this->_invoiceService = $invoiceService;
        $this->_transaction = $transaction;
        parent::__construct($context);
    }
	
	
    public function execute()
    {
		
	if ($this->getRequest()->isPost() && !empty($_FILES['import_orderstatus_file']['tmp_name'])) {
           
                
                $comment = $_POST['comments'];
                $gorderstatus = $_POST['orderstatus_code']; 
                $checkbox_state = $this->getRequest()->getPostValue('createinvoce');
				$customernotify = $this->getRequest()->getPostValue('customernotify');
				$this->getRequest()->getPostValue();
				
			if($checkbox_state)
			{
				$checkbox_state =1;
				
			}	
			else 
			{
				$checkbox_state =0;
			}
		
                try { 
				
				
                
                $this->_importTrackingFile($_FILES['import_orderstatus_file']['tmp_name'],$comment,$gorderstatus,$checkbox_state,$customernotify);
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                
                $this->messageManager->addError('Invalid file upload attempt');
            }
        }
        else {
			
            $this->messageManager->addError('Invalid file upload attempt');
        }
        $this->_redirect('*/*/index');
    }
	 protected function _importTrackingFile($fileName,$comment,$gorderstatus,$checkbox_state,$customernotify)
    {
        /**
         * File handling
         **/
        ini_set('auto_detect_line_endings', true);
        $csvObject = new \Magento\Framework\File\Csv(new \Magento\Framework\Filesystem\Driver\File());  
        $csvData = $csvObject->getData($fileName);

        /**
         * File expected fields
         */
        $expectedCsvFields  = array(
            0   => /* @escapeNotVerified */__('Order Id')
        );

        /**
         * $k is line number
         * $v is line content array
         */
        foreach ($csvData as $k => $v) 
        {
            if ($k == 0) {
                 continue;
              }
            /**
             * End of file has more than one empty lines
             */
            if (count($v) <= 1 && !strlen($v[0])) {
                continue;
            }

            /**
             * Check that the number of fields is not lower than expected
             */
            if (count($v) < count($expectedCsvFields)) {
                $this->messageManager->addError($this->__('Line %s format is invalid and has been ignored', $k));
                continue;
            }

            /**
             * Get fields content
             */
            $orderId = $v[0];

            if ($orderId =='') {                
                continue;
            }
            /* for debug */
            //$this->_getSession()->addSuccess($this->__('Lecture ligne %s: %s', $k, $orderId));

            /**
             * Try to load the order
             */
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $order = $objectManager->create('\Magento\Sales\Model\Order')
                           ->loadByIncrementId($orderId); 
                           //->load($orderId); 
            if (!$order->getId()) {
                $this->messageManager->addError(__('Order %s does not exist', $orderId));
                continue;
            }

            /**
             * Try to change order status 
             */
            $orderprocess = $this->_changeStatus($order,$comment,$gorderstatus,$checkbox_state,$customernotify);

            if ($orderprocess) {
                $this->messageManager->addSuccess(__('Order status changed for order %s', $orderId));
            }
        }//foreach

    }

    /**
     * Create new shipment for order
     * Inspired by Mage_Sales_Model_Order_Shipment_Api methods
     *
     * @param Mage_Sales_Model_Order $order (it should exist, no control is done into the method)
     * @param string $comment
     * @return staus
     */
    public function _changeStatus($order,$comment,$gorderstatus,$checkbox_state,$customernotify)
    {
            //Mage::log($order->getState()." - ".$gorderstatus." - checkbox- ".$checkbox_state,null,'ostatus.log'); 
            if($gorderstatus == "default"){
                $gorderstatus = $order->getStatus();
                //Mage::log($order->getState()." - ".$gorderstatus." - checkbox- ".$checkbox_state,null,'ostatus.log');    
            }
                $gorderstatus = $gorderstatus;
                $gorderid = $order->getId();
            
			// $sqlqrynew = "UPDATE `sales_order` SET `status` = '".$gorderstatus."' WHERE `entity_id` = $gorderid";
	 // $resourcenew = $this->_objectManager->create('\Magento\Framework\App\ResourceConnection');
  
 
        
        // $resultnew = $resourcenew->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION)
        // ->query($sqlqrynew);
		
		

$order->setStatus($gorderstatus);

$order->addStatusToHistory($order->getStatus(), $comment);
$orderCommentSender = $this->_objectManager
          ->create('Magento\Sales\Model\Order\Email\Sender\OrderCommentSender');
		  if($customernotify == "1"){
		  
$orderCommentSender->send($order, true, $comment);
		  }

//$this->_objectManager->get('Magento\Sales\Model\Order\Email\Sender\OrderSender')->send($order);
 
$isCustomerNotified = $order->setIsCustomerNotified(true);
			
			
			 if($checkbox_state == "1"){
			
	         $invoice = $this->_invoiceService->prepareInvoice($order);
            $invoice->register();
            $invoice->save();
            $transactionSave = $this->_transaction->addObject(
                $invoice
            )->addObject(
                $invoice->getOrder()
            );
            $transactionSave->save();
			//$invoiceSender = $this->_objectManager->create('Magento\Sales\Model\Order\Email\Sender\InvoiceSender');
		   //$invoiceSender->send($invoice);
            //$this->invoiceSender->send($invoice);
				
       }
            $gstate = $this->_getAssignedState($gorderstatus);
            // try{
                // $order_status = array('complete','closed');
                // if(in_array($gstate,$order_status)) {
                    // $order->setCustomerNote($comment)->setCustomerNoteNotify(true)
                        // ->addStatusToHistory($gorderstatus,$order->getCustomerNote(),$order->getCustomerNoteNotify())
                        // ->sendOrderUpdateEmail($order->getCustomerNoteNotify(), $order->getCustomerNote())
                        // ->save();
                  // $this->messageManager->addSuccess(__('Status changed for %s',$order->getIncrementId()));                                  
                // }else {
                    // $isCustomerNotified = (1 == $customernotify)? true : false;
                    // $order->setState($gstate, $gorderstatus, $comment, $isCustomerNotified)
                          // ->setCustomerNote($comment)
                          // ->save();
                    // if($isCustomerNotified){
                     // // $order->sendOrderUpdateEmail(true, $comment);
                    // }
                    // $this->messageManager->addSuccess(__('Status changed for %s',$order->getIncrementId()));
                // } 
            // }catch (Exception $e) {
                // $this->messageManager->addError(__('There is an error %s : %s',$order->getIncrementId()),$e->getMessage());                       
            // }
			      $order->setState($gstate, $gorderstatus, $comment, $isCustomerNotified)                                                    ->save();
			
			//$order->save();
   
           $this->messageManager->addSuccess(__('Email send to  %s',$order->getIncrementId()));                       
    }
 
    protected function _getAssignedState($status)
    {
		
        $sqlqry = "SELECT `main_table`.*, `state_table`.`state` AS ostate, `state_table`.`is_default` FROM `sales_order_status` AS `main_table`
 LEFT JOIN `sales_order_status_state` AS `state_table` ON main_table.status=state_table.status WHERE (main_table.status = '".$status."') ORDER BY FIELD(ostate,'".$status."','other')";
 
 
 
 $resource = $this->_objectManager->create('\Magento\Framework\App\ResourceConnection');
  //$connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
 
        //$resource = Mage::getSingleton('core/resource');
        $result = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION)
        ->fetchRow($sqlqry);
        return $result["ostate"];
    }
	
	protected function _isAllowed(){
        return true;
    }


}

?>