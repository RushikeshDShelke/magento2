<?php

namespace Themecafe\CCAvenue\Controller\Ccavenue;

class Response extends \Themecafe\CCAvenue\Controller\Checkout {

    public function execute() {

        // Initialize return url
        $returnUrl = $this->getCheckoutHelper()->getUrl('checkout');
        $this->_checkoutSession->getData('startCCPayment', true);
        try {

//            ini_set('display_errors', 1);
//            error_reporting(1);
            $paymentMethod = $this->getPaymentMethod();
            $config = $this->getCheckoutConfig();

            // Get payment method code
            $code = $paymentMethod->getCode();

            // Get params from response
            $response = $this->getRequest()->getParams();

            $params = $config->decryptResponse($response['encResp']);
            $this->getCheckoutConfig()->recordLog('RESPONSE : ' . json_encode($params));
            $orderNo = $params['order_id'];

            if (isset($params['order_id']))
                $orderNumber = $params['order_id'];
            if (isset($params['tracking_id']))
                $tracking_id = $params['tracking_id'];
            if (isset($params['order_status']))
                $order_status = $params['order_status'];
            if (isset($params['currency']))
                $currency = $params['currency'];
            if (isset($params['amount']))
                $orderTotal = $params['amount'];

            // Set Comments for response            
            $order_history_comments = '';
            $order_history_keys = array('tracking_id', 'failure_message', 'payment_mode', 'card_name', 'status_code', 'status_message', 'bank_ref_no', 'offer_type', 'offer_code', 'discount_value', 'mer_amount');
            foreach ($order_history_keys as $order_history_key) {
                if ((isset($params[$order_history_key])) && trim($params[$order_history_key]) != '') {
                    if (trim($params[$order_history_key]) == 'null')
                        continue;
                    $order_history_comments .= $order_history_key . " : " . $params[$order_history_key] . " | ";
                }
            }

            $order_history_comments_array = array();
            $order_history_comments_array[] = $order_history_comments;

            // Create the order if the response passes validation
            if ($order_status == "Success") {
                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/success');

                //ini_set('display_error', '1');
                //error_reporting(1);
                //check quote in session is exists or not
                //$this->initCheckout();
                //load order from session
                $order = $this->getOrderById($orderNumber);

                //load quote from Order
                $quoteId = $order->getQuoteId();

                // prepare session to success or cancellation page
                $this->getCheckoutSession()->clearHelperData();

                // "last successful quote"
                $this->getCheckoutSession()->setLastQuoteId($quoteId)->setLastSuccessQuoteId($quoteId);

                $payment = $order->getPayment();
                //$order->setState(\Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW);
                //$order->setStatus(\Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW);
                $order->setState(\Magento\Sales\Model\Order::STATE_NEW);
                $order->setStatus('pending');
                
                $order->addStatusHistoryComment((__('[CCAvenue Order Reference No : '.$orderNumber.']')))->setIsCustomerNotified(false);
                $order->addStatusHistoryComment(__('[CCAvenue Notification Processed] "'.$order_history_comments.'"' ))->setIsCustomerNotified(false);
                $paymentMethod->postProcessing($order, $payment, $params);
                //$this->getCheckoutConfig()->recordLog(json_encode($order->getPayment()));
                //again set order in session so that success page will be rendered
                if ($order) {
                    $this->getCheckoutSession()->setLastOrderId($order->getId())
                            ->setLastRealOrderId($order->getIncrementId())
                            ->setLastOrderStatus($order->getStatus());
                }
            } else {
                $this->_cancelPayment();
                $this->_checkoutSession->restoreQuote();
                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/failure');
            }
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('We can\'t place the order : ' . $e->getMessage()));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            //echo $e->getMessage();
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        } catch (\Exception $e) {
            //echo $e->getMessage().__('We can\'t place the order.');
            $this->messageManager->addExceptionMessage($e, $e->getMessage() . __('We can\'t place the order.'));
        }
//        echo $returnUrl;
        $this->getResponse()->setRedirect($returnUrl);
    }

}
