<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;
// use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
// use \Magento\Sales\Api\Data\OrderInterface;

class SalesOrderSuccessObserver implements ObserverInterface
{
    protected $checkoutSession;
    protected $_order;
    protected $catalogSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
         \Magento\Catalog\Model\Session $catalogSession,  
         \Magento\Sales\Model\Order $order
    ) {
        $this->_checkoutSession = $checkoutSession;  
        $this->catalogSession = $catalogSession;
        $this->_order = $order;  
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
        $logger->info('--------------------');

        // Array ( [0] => isValidFor [1] => dispatch [2] => getName [3] => setName [4] => getEventName [5] => setEventName [6] => getCallback [7] => setCallback [8] => getEvent [9] => setEvent [10] => __construct [11] => addData [12] => setData [13] => unsetData [14] => getData [15] => getDataByPath [16] => getDataByKey [17] => setDataUsingMethod [18] => getDataUsingMethod [19] => hasData [20] => toArray [21] => convertToArray [22] => toXml [23] => convertToXml [24] => toJson [25] => convertToJson [26] => toString [27] => __call [28] => isEmpty [29] => serialize [30] => debug [31] => offsetSet [32] => offsetExists [33] => offsetUnset [34] => offsetGet )


        // $order = $observer->getEvent()->getOrder();
        $orderids = $observer->getEvent()->getOrderIds();
        // echo $observer->getEventName();
        $order = $this->_order->load($orderids[0]);
        // $quote = $observer->getEvent()->getQuote();
        $couponInfo = $this->_checkoutSession->getCouponInfo();
        // echo $this->catalogSession->getCouponAmount();
        // print_r($couponInfo);exit;

        // $logger->info(print_r($couponInfo,true));
        // die;
        if (isset($couponInfo['vouchagram'])) {
            $order->setData('coupondiscount_total', $this->catalogSession->getCouponAmount());
            $order->setData('coupondiscount_code', $couponInfo['vouchagram']['coupon_code']);

            $this->_checkoutSession->unsCouponInfo();
            $this->catalogSession->unsCouponAmount();   
            $order->save();
        } 
        
    }
}
