<?php
namespace Themecafe\CCAvenue\Controller\Ccavenue;
class Add extends \Magento\Framework\App\Action\Action {

         /**
          * @var \Magento\Checkout\Model\Cart
          */
         protected $cart;
         /**
          * @var \Magento\Catalog\Model\Product
          */
         protected $product;

         public function __construct(
             \Magento\Framework\App\Action\Context $context,
             \Magento\Framework\View\Result\PageFactory $resultPageFactory,
             \Magento\Catalog\Model\Product $product,
             \Magento\Checkout\Model\Cart $cart
         ) {
             $this->resultPageFactory = $resultPageFactory;
           //  $this->_customerSession = $customerSession;
             $this->cart = $cart;
             $this->product = $product;
             parent::__construct($context);
         }
         public function execute()
         {
             /*try {
                 $params = array();
                 $params['qty'] = '1';//product quantity
                 /*get product id*/
                /* $pId = '1';//productId
                 $_product = $this->product->load($pId);
                 if ($_product) {
                     $this->cart->addProduct($_product, $params);
                     $this->cart->save();
                 }

                 $this->messageManager->addSuccess(__('Add to cart successfully.'));
             } catch (\Magento\Framework\Exception\LocalizedException $e) {
                 $this->messageManager->addException(
                     $e,
                     __('%1', $e->getMessage())
                 );
             } catch (\Exception $e) {
                 $this->messageManager->addException($e, __('error.'));
             }*/
             /*cart page*/
             //$this->getResponse()->setRedirect('/magento2/checkout/');

 $this->_cclogger->debug('RESPONSE : ', array('salma'));
         }
    }
