<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteRemoveItemObserver implements ObserverInterface
{
   
    protected $checkoutSession;

    protected $catalogSession;

    protected $_objectManager;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
         \Magento\Catalog\Model\Session $catalogSession ,
         \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_checkoutSession = $checkoutSession;  
        $this->catalogSession = $catalogSession;
        $this->_objectManager = $objectManager;
    }

    /**
     * sales_quote_remove_item event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/coupon_cron.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("--------------------");
        $logger->info( $this->_checkoutSession->getQuote()->getItemsCount());
        if($this->_checkoutSession->getQuote()->getItemsCount()==1){
            $this->_checkoutSession->unsCouponInfo();
            $this->catalogSession->unsCouponAmount();             
            $this->_checkoutSession->getQuote()->collectTotals()->save();
            $collection = $this->_objectManager->create('M2s\Vouchagram\Model\Vouchagram')->getCollection()->addFieldToFilter("quote_id",$this->_checkoutSession->getQuote()->getId());
            foreach ($collection as $each) {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/Cancel?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&requestjobnumber='.$each->getQuoteId().'&billvalue='.$each->getQuoteValue().'&voucherNumber='.$each->getCouponCode(),
                    CURLOPT_USERAGENT => 'ShopCrocs.in'
                ]);
                $each->delete();
                $resp = json_decode(curl_exec($curl));
                $response = $resp->vCancelResult[0];

                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/coupon_cron.log');
            }
        }

    }
}
