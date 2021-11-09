<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteSubmitSuccessObserver implements ObserverInterface
{
    protected $checkoutSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_checkoutSession = $checkoutSession;  
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
        $logger->info('--------------------quote submitted');
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        $couponInfo = $this->_checkoutSession->getCouponInfo();
        // $logger->info(print_r($couponInfo,true));
        // die;
        // if (isset($couponInfo['vouchagram'])) {
            // $order->setData('coupondiscount_total', $couponInfo['vouchagram']['amount']);
            // $order->setData('coupondiscount_code', $couponInfo['vouchagram']['coupon_code']);

            
            // $order->setData('discount_amount', abs($shippingAddress->getData('coupondiscount_total')));
        // } 
        // $this->_checkoutSession->unsCouponInfo();
        // $order->save();
    }
}
