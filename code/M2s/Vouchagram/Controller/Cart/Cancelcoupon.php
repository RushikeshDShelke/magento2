<?php

namespace M2s\Vouchagram\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;


class Cancelcoupon extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $_cartModel;

    protected $quote;

    protected $_objectManager;
    
    protected $request;
    protected $checkoutSession;
    protected $catalogSession;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Checkout\Model\Cart $cartModel,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\Session $catalogSession  
        // \Magento\Quote\Model\Quote $quote,
        // \Magento\Quote\Model\Quote\Address\Total $total
    ) 
    {
        $this->_messageManager = $context->getMessageManager();
        $this->_resultPageFactory = $resultPageFactory;
        $this->_cartModel = $cartModel;
        $this->_storeManager = $storeManager;
        $this->_quote = $checkoutSession->getQuote();
        $this->_session = $checkoutSession;  
        $this->request = $request;  
        $this->catalogSession = $catalogSession;
        $this->_objectManager = $objectManager;
        // $this->_quote = $quote;
        // $this->_total = $total;

        parent::__construct($context);
    }

    public function execute()
    { 
        echo "Cancellation cron started";
        $orderCollection = $this->_objectManager->create('Magento\Sales\Model\Order')->getCollection()->addFieldToFilter("coupondiscount_code",array("neq"=>''));
        $orderArray = array();
        foreach ($orderCollection as $value) {
            $each = explode(',', $value->getData("coupondiscount_code"));
            $orderArray = array_merge($orderArray, $each);
        }
        // echo "<pre>";
        // print_r($orderArray);
        // die;
        $collection = $this->_objectManager->create('M2s\Vouchagram\Model\Vouchagram')->getCollection();
        foreach ($collection as $each) {
            if(!in_array($each->getCouponCode(), $orderArray)){
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/Cancel?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&requestjobnumber='.$each->getQuoteId().'&billvalue='.$each->getQuoteValue().'&voucherNumber='.$each->getCouponCode(),
                    CURLOPT_USERAGENT => 'ShopCrocs.in'
                ]);
                $each->delete();
                $resp = json_decode(curl_exec($curl));
                if($resp->vCancelResult){
                    $response = $resp->vCancelResult[0];

                    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/coupon_cron.log');
                    $logger = new \Zend\Log\Logger();
                    $logger->addWriter($writer);
                    $logger->info("--------------".date("M,d,Y h:i:s A")."------------");
                    $logger->info(json_encode($response));
                }
            }
        }
    }

}
