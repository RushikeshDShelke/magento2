<?php

namespace Invanos\Rma\Controller\Adminhtml\Request;

use Amasty\Rma\Controller\Adminhtml\Request as RequestAction;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class MassAction extends RequestAction
{
    const ENCLOSURE = '"';
    const DELIMITER = ',';

    /**
     * @var Item
     */
    protected $rmaItem;

     /**
     * @var ItemFactory
     */
    private $rmaItemFactory;
  
    protected $_directoryList;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @param Context $context
     * @param Filter $filter
     */
    public function __construct(Context $context, Filter $filter,DirectoryList $directory_list)
    {
        $this->filter = $filter;
        parent::__construct($context);
        $this->_directoryList = $directory_list;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        if (!file_exists($this->_directoryList->getRoot().'/pub/media/rmaexport')) {
            mkdir($this->_directoryList->getRoot().'/pub/media/rmaexport', 0777, true);
        }

        $todayDate = date('Y_m_d_H_i_s', time());
        $fileName = $this->_directoryList->getRoot().'/pub/media/rmaexport/rmaexport'.$todayDate.'.csv';
        
        
        $fp = fopen($fileName, 'w');
        $this->writeHeadRow($fp);
        
        $countOrderExport = 0;

        $action = $this->getRequest()->getParam('action');

        $rawCollection = $this->_objectManager->create('\Amasty\Rma\Model\ResourceModel\Request\Collection');

        $collection = $this->filter->getCollection($rawCollection);
        $collectionSize = $collection->getSize();

        foreach ($collection as $_rmaorder) {
            $this->writeRmaOrder($_rmaorder, $fp);
            $countOrderExport++; 
        }

        fclose($fp);

        $this->downloadCsv($fileName);      
        $this->messageManager->addSuccess(__('We Exported %1 order(s).', $countOrderExport));

        
    }

    public function downloadCsv($file)
    {
        
        if (file_exists($file)) {
            //set appropriate headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();flush();
            readfile($file);
        }
    }

    protected function writeRmaOrder($rmaorder, $fp) 
    {
        $common = $this->getCommonOrderValues($rmaorder);

        $orderItems = $this->_objectManager->create('\Amasty\Rma\Model\ResourceModel\Item\Collection');
        $orderItems->addFilter('request_id', $rmaorder->getId());
        
        $itemInc = 0;
        $item = "";
        foreach ($orderItems as $item)
        {
            //var_dump($item->getData());die;
            $record = array_merge($common, $this->getOrderItemValues($item, ++$itemInc));
            fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
        }
    }

    protected function writeHeadRow($fp) 
    {
        fputcsv($fp, $this->getHeadRowValues(), self::DELIMITER, self::ENCLOSURE);
    }

    protected function getHeadRowValues() 
    {
        return array(
            'ID',
            'Order No',
            'Email',
            'Customer',
            'Code',
            'item count',            
            'Item Name',
            'Item SKU',
            'Reason',
            'Item Condition',            
            'Reason to Return',
            'Qty',
        );
    }

    protected function getCommonOrderValues($rmaorder) 
    {
        
        return array(
            $rmaorder->getId(),
            $rmaorder->getIncrementId(),
            $rmaorder->getEmail(),
            $rmaorder->getCustomerFirstname()." ".$rmaorder->getCustomerLastname(),
            $rmaorder->getCode(),
        );
        
    }

    protected function getOrderItemValues($item, $itemInc=1) 
    {
        
        return array(
            $itemInc,
            $item->getName(),            
            $item->getSku(),
            $item->getReason(),
            $item->getCondition(),
            $item->getResolution(),
            (int)$item->getQty()
        );
    }
}
