<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;

class UpdatecartObserver implements ObserverInterface
{
    protected $checkoutSession;

    protected $catalogSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
         \Magento\Catalog\Model\Session $catalogSession  
    ) {
        $this->_checkoutSession = $checkoutSession;  
        $this->catalogSession = $catalogSession;
    }
    /**
     * sales_model_service_quote_submit_success event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('--------------------UpdatecartObserver--'.$this->_checkoutSession->getQuote()->getBaseGrandTotal());
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        $couponInfo = $this->_checkoutSession->getCouponInfo();
        $couponAmount = $this->catalogSession->getCouponAmount();
        if($couponInfo['vouchagram']){
            
            // $this->catalogSession->unsCouponAmount();                            
            $this->_checkoutSession->getQuote()->collectTotals()->save();
            $amountValue = $couponInfo['vouchagram']['actual_value']>$this->_checkoutSession->getQuote()->getBaseGrandTotal()?$this->_checkoutSession->getQuote()->getBaseGrandTotal():$couponInfo['vouchagram']['actual_value'];
            $logger->info("-----".$amountValue);
            // if($amountValue):
            $this->catalogSession->unsCouponAmount();                            
            $this->catalogSession->setCouponAmount(abs($amountValue));
            $this->_checkoutSession->getQuote()->collectTotals()->save();
            // endif;
            $couponInfo['vouchagram'] = [
                'coupon_code'=>$couponInfo['vouchagram']['coupon_code'],
                'amount'=>-$amountValue,
                'actual_value'=>$couponInfo['vouchagram']['actual_value']
            ];
                
            $this->_checkoutSession->setCouponInfo($couponInfo);
        }
    }
}
