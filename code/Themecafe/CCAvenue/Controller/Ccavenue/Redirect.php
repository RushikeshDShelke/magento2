<?php

namespace Themecafe\CCAvenue\Controller\Ccavenue;

use \Magento\Framework\Exception\LocalizedException;

class Redirect extends \Themecafe\CCAvenue\Controller\Checkout {

    public function execute() {
       try {
            //check page is refreeshed based on session set
            $startedAlready = $this->_checkoutSession->getData('startCCPayment');
            if (isset($startedAlready) && $startedAlready == 1) {
                $this->_cancelPayment();
                $this->_checkoutSession->restoreQuote();
                $this->_checkoutSession->getData('startCCPayment', true);
                $this->getResponse()->setRedirect(
                        $this->getCheckoutHelper()->getUrl('checkout/onepage/failure')
                );

            } else {
                $this->_checkoutSession->setData('startCCPayment', '1');
                // Get payment method code
                $paymentMethod = $this->getPaymentMethod();
                $code = $paymentMethod->getCode();

                //get quote from session
                $quote = $this->getQuote();



                //get Email to set for guest user

                if ($quote->getCustomerEmail()) {
                    $email = $quote->getCustomerEmail();
                } elseif ($quote->getBillingAddress()->getEmail()) {
                    $email = $quote->getBillingAddress()->getEmail();
                } elseif ($this->getRequest()->getParam('email')) {
                    $email = $this->getRequest()->getParam('email');
                } else {
                    throw new LocalizedException(__("Your email address is empty."));
                }
//                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//                $onepage = $objectManager->get('Magento\Checkout\Model\Session');
//                $request = $objectManager->get('Magento\Framework\App\Request\Http');

                if ($this->getCustomerSession()->isLoggedIn()) {
//                    $this->getCheckoutSession()->loadCustomerQuote();
//                    $quote->updateCustomerData($this->getQuote()->getCustomer());
		    $quote->setCheckoutMethod(\Magento\Checkout\Model\Type\Onepage::METHOD_CUSTOMER);
                } else {
                    $quote->setCheckoutMethod(\Magento\Checkout\Model\Type\Onepage::METHOD_GUEST);
                    $quote->setCustomerEmail($email);
                    $quote->setCustomerIsGuest(1);
                }

//                $onepage->_prepareGuestQuote();
                //save quote with updated details
                $this->quoteRepository->save($quote);

                //Set payment Method in Quote
                $quote->setPaymentMethod($code);
//                $quote->setInventoryProcessed(false);
                $quote->save();
                $quote->getPayment()->importData(['method' => $code]);
                $quote->collectTotals()->save();

                // Create Order From Quote
                $order = $this->quoteManagement->submit($quote);
                // prepare session to success or cancellation page
                $this->getCheckoutSession()->clearHelperData();

                // "last successful quote"
                $quoteId = $quote->getId();
                $this->getCheckoutSession()->setLastQuoteId($quoteId)->setLastSuccessQuoteId($quoteId);

                //$order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                //$order->setStatus(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                $order->setState(\Magento\Sales\Model\Order::STATE_NEW);
                $order->setStatus('pending');
                
                $order->setEmailSent(0);
                $order->save();

                //Restore order in CheckoutSession so that we can use it on response page
                if ($order) {
                    $this->getCheckoutSession()->setLastOrderId($order->getId())
                            ->setLastRealOrderId($order->getIncrementId())
                            ->setLastOrderStatus($order->getStatus());
                }

                $params = [];
                $data = $this->getCheckoutConfig()->getCheckoutFormFields($order, $this->getRequest()->getParams());
		
                if ($this->getCheckoutConfig()->getIntegrationTechnique() != 'redirect') {
                    
                    $params["url"] = $this->getPaymentMethod()->getCgiUrl() . '&encRequest=' . $data['encRequest'] . '&access_code=' . $data['access_code'];
                    $this->_checkoutSession->setData('iframeURL', $params["url"]);
                    $this->_checkoutSession->setData('ccavenueQuoteId', $quote->getId());
                    $this->_checkoutSession->getData('iframeURL');
                    $this->_checkoutSession->getData('ccavenueQuoteId');

                    //render page of IFRAME
                    $this->_view->loadLayout();
                    $this->_view->getLayout()->initMessages();
                    $this->_view->getPage()->getConfig()->getTitle()->set('');
                    $resultPage = $this->resultPageFactory->create();
                    return $resultPage;
                } else {
                    $params["url"] = $this->getPaymentMethod()->getCgiUrl() ;
                    $params["fields"] = $data;
                    echo json_encode($params);
               }
            }
       } catch (\Exception $ex) {
            $this->messageManager->addExceptionMessage($ex, __('We can\'t place the order : ' . $ex->getMessage()));
            $this->_cancelPayment();
            $this->_checkoutSession->restoreQuote();
            $this->_checkoutSession->getData('startCCPayment', true);
            $this->getResponse()->setRedirect(
                    $this->getCheckoutHelper()->getUrl('checkout/onepage/failure')
            );
        }
    }

}

