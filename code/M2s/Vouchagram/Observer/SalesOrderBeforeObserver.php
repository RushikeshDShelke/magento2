<?php

namespace M2s\Vouchagram\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\PaymentException;

class SalesOrderBeforeObserver implements ObserverInterface
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
        $logger->info('--------------------');
        $quote = $observer->getEvent()->getQuote();
        $couponInfo = $this->_checkoutSession->getCouponInfo();
        // $logger->info(print_r($couponInfo,true));
        // die;
        if (isset($couponInfo['vouchagram'])) {
            // $order->setData('coupondiscount_total', $this->catalogSession->getCouponAmount());
            // $order->setData('coupondiscount_code', $couponInfo['vouchagram']['coupon_code']);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/QueryVoucher?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&voucherNumber='.$couponInfo['vouchagram']['coupon_code'],
                CURLOPT_USERAGENT => 'ShopCrocs.in'
            ]);
            // Send the request & save response to $resp
            $resp = json_decode(curl_exec($curl));
            $response = $resp->vQueryVoucherResult[0];
            $logger->info("errorrr");
            $logger->info($response->Status);
            if($response->Status!="CONSUMED"){
                throw new PaymentException(__('Something went wrong. Please remove GyFTR coupon and try again.'));
            }
        }

        // $this->_checkoutSession->unsCouponInfo();
        // $this->catalogSession->unsCouponAmount();  

        // // created log by nilesh
        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/beforeOrderPlace.log');
        // $logger = new \Zend\Log\Logger();
        // $logger->addWriter($writer);
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        // $logger->info('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

        // $order = $observer->getEvent()->getOrder();

        // $logger->info('---customer info start----');

        //     $customerId = $order->getCustomerId();
        //     $customerName = $order->getCustomerName();
        //     $customerEmail = $order->getCustomerEmail();
        //     $quoteId = $order->getQuoteId();
        //     $customerIsGuest = $order->getCustomerIsGuest();
        //     $billingAddress = $order->getBillingAddress()->getData(); 
        //     $billingCustomerAddressId = $order->getBillingAddress()->getCustomerAddressId();
        //     $billingRegion = $order->getBillingAddress()->getRegion();
        //     $billingStreet = $order->getBillingAddress()->getStreet();
        //     $billingCity = $order->getBillingAddress()->getCity();
        //     $billingEmail = $order->getBillingAddress()->getEmail();
        //     $billingTelephone = $order->getBillingAddress()->getTelephone();
        //     $billingCountryId = $order->getBillingAddress()->getCountryId();
        //     $billingRegionId = $order->getBillingAddress()->getRegionId();
        //     $shippingAddress = $order->getShippingAddress()->getData();
        //     $shippingCustomerAddressId = $order->getShippingAddress()->getCustomerAddressId();
        //     $shippingRegion = $order->getShippingAddress()->getRegion();
        //     $shippingStreet = $order->getShippingAddress()->getStreet();
        //     $shippingCity = $order->getShippingAddress()->getCity();
        //     $shippingEmail = $order->getShippingAddress()->getEmail();
        //     $shippingTelephone = $order->getShippingAddress()->getTelephone();
        //     $shippingCountryId = $order->getShippingAddress()->getCountryId();
        //     $shippingRegionId = $order->getShippingAddress()->getRegionId();

        //     $customerArray = array(
        //         'customerId'=> $customerId,
        //         'customerName'=> $customerName,
        //         'customerEmail'=> $customerEmail,
        //         'quoteId'=> $quoteId,
        //         'billingCustomerAddressId' => $billingCustomerAddressId,
        //         'billingRegion' => $billingRegion,
        //         'billingStreet' => $billingStreet,
        //         'billingCity' => $billingCity,
        //         'billingEmail' => $billingEmail,
        //         'billingTelephone' => $billingTelephone,
        //         'billingCountryId' => $billingCountryId,
        //         'billingRegionId' => $billingRegionId,
        //         'shippingCustomerAddressId' => $shippingCustomerAddressId,
        //         'shippingRegion' => $shippingRegion,
        //         'shippingStreet' => $shippingStreet,
        //         'shippingCity' => $shippingCity,
        //         'shippingEmail' => $shippingEmail,
        //         'shippingTelephone' => $shippingTelephone,
        //         'shippingCountryId' => $shippingCountryId,
        //         'shippingRegionId' => $shippingRegionId
        //     );
        //     $logger->info(json_encode($customerArray));

        // $logger->info('---customer info end----');


        // $logger->info('---product info start----');

        //     $cart = $objectManager->get('\Magento\Quote\Model\QuoteFactory');
        //     $quote = $cart->create()->load($quoteId);
        //     $items = $quote->getAllItems();
        //     $itemsCounts = count($items);
            
        //     foreach ($items as $item) {
        //         if ($item->getProductType() == 'simple') {
        //             $itemProductId = $item->getProductId();
        //             $itemName = $item->getName();
        //             $itemSku = $item->getSku();
        //             $itemQty = $item->getQty();
        //             $itemPrice = $item->getPrice();

        //             $itemArray = array(
        //                 'itemProductId' => $itemProductId,
        //                 'itemName' => $itemName,
        //                 'itemSku' => $itemSku,
        //                 'itemQty' => $itemQty,
        //                 'itemPrice' => $itemPrice
        //             );
        //             $logger->info(json_encode($itemArray));
        //         }
        //     }

        // $logger->info('---product info end----');


        // $logger->info('---order data start----');

        //     $incrementId = $order->getIncrementId();
        //     $baseGrandTotal = $order->getBaseGrandTotal();
        //     $payment = $order->getPayment();
        //     $method = $payment->getMethodInstance();
        //     $paymentCode = $method->getCode();

        //     $orderDataArray = array(
        //         'incrementId'=> $incrementId,
        //         'baseGrandTotal'=> $baseGrandTotal,
        //         'paymentCode' => $paymentCode,
        //     );
        //     $logger->info(json_encode($orderDataArray));

        // $logger->info('---order data end----');

        // $logger->info('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
    }
}
