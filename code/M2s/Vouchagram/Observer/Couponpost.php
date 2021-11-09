<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;

class Couponpost implements ObserverInterface
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
        // $couponCode = $this->getRequest()->getParam('remove') == 1
        //     ? ''
        //     : trim($this->getRequest()->getParam('coupon_code'));
        // $logger->info('--------------------Couponpost--'.$couponCode);
        $logger->info($this->_checkoutSession->getQuote()->getBaseGrandTotal());
        $controller = $observer->getControllerAction();
        $remove = $controller->getRequest()->getParam('remove');

        if ($remove) {
            $couponInfo = $this->_checkoutSession->getCouponInfo();
            $couponAmount = $this->catalogSession->getCouponAmount();
            if($couponInfo['vouchagram']){
                $this->_checkoutSession->getQuote()->collectTotals()->save();
                $amountValue = $couponInfo['vouchagram']['actual_value']>$this->_checkoutSession->getQuote()->getBaseGrandTotal()?$this->_checkoutSession->getQuote()->getBaseGrandTotal():$couponInfo['vouchagram']['actual_value'];
                $this->catalogSession->unsCouponAmount();                            
                $this->catalogSession->setCouponAmount(abs($amountValue));
                $this->_checkoutSession->getQuote()->collectTotals()->save();
            }
        } else {
            // This is an add action
            $coupon = $controller->getRequest()->getParam('coupon_code');
            $couponInfo = $this->_checkoutSession->getCouponInfo();
            $couponAmount = $this->catalogSession->getCouponAmount();
            $this->_checkoutSession->getQuote()->collectTotals()->save();
            $logger->info('--------------------Couponpost--'.$this->_checkoutSession->getQuote()->getBaseGrandTotal());
            if($couponInfo['vouchagram']){
                $this->_checkoutSession->getQuote()->collectTotals()->save();
                $amountValue = $couponInfo['vouchagram']['actual_value']>$this->_checkoutSession->getQuote()->getBaseGrandTotal()?$this->_checkoutSession->getQuote()->getBaseGrandTotal():$couponInfo['vouchagram']['actual_value'];
                $this->catalogSession->unsCouponAmount();                            
                $this->catalogSession->setCouponAmount(abs($amountValue));
                $this->_checkoutSession->getQuote()->collectTotals()->save();
            }
        }

        
    }
}
