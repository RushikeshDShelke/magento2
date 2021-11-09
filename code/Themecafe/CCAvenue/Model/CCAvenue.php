<?php

namespace Themecafe\CCAvenue\Model;

use Magento\Quote\Model\Quote\Payment;

class CCAvenue extends \Magento\Payment\Model\Method\AbstractMethod {

    const CODE = 'ccavenue';

    protected $_code = self::CODE;
    protected $_isGateway = false;
    protected $_isOffline = false;
    protected $_canRefund = true;
    protected $_isInitializeNeeded = false;
    protected $helper;
    protected $_minAmount = null;
    protected $_maxAmount = null;
    protected $_supportedCurrencyCodes = array(
        'INR'
    );
    protected $_formBlockType = 'Themecafe\CCAvenue\Block\Form\Checkout';
//    protected $_infoBlockType = 'Themecafe\CCAvenue\Block\Info\Checkout';
    //protected $_formBlockType = 'Magento\Payment\Block\Form';
    protected $_infoBlockType = 'Themecafe\CCAvenue\Block\Info';
    protected $httpClientFactory;
    protected $orderSender;

    public function __construct(
    \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Payment\Model\Method\Logger $logger, \Themecafe\CCAvenue\Helper\Checkout $helper, \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender, \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
    ) {
        $this->helper = $helper;
        $this->orderSender = $orderSender;
        $this->httpClientFactory = $httpClientFactory;
        parent::__construct(
                $context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger
        );

        $this->_minAmount = $this->getConfigData('min_order_total');
        $this->_maxAmount = $this->getConfigData('max_order_total');
    }

    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null) {
        if ($quote && (
                $quote->getBaseGrandTotal() < $this->_minAmount || ($this->_maxAmount && $quote->getBaseGrandTotal() > $this->_maxAmount))
        ) {
            return false;
        }

        return parent::isAvailable($quote);
    }

    public function canUseForCurrency($currencyCode) {
        if (!in_array($currencyCode, $this->_supportedCurrencyCodes)) {
            return false;
        }
        return true;
    }

    public function postProcessing(\Magento\Sales\Model\Order $order, \Magento\Framework\DataObject $payment, $params) {
        // Update payment details
        $payment->setTransactionId($params['tracking_id']);
        $payment->setCurrencyCode($params['currency']);
        //$payment->setParentTransactionId($params['order_id']);
        $payment->registerCaptureNotification($params['amount'], true);
        $payment->setIsTransactionClosed(0);
        $payment->setTransactionAdditionalInfo('ccavenue_order_number', $params['order_id']);
        $payment->setAdditionalInformation('ccavenue_order_number', $params['order_id']);
        $payment->setAdditionalInformation('payment_mode', $params['payment_mode']);
        $payment->setAdditionalInformation('ccavenue_order_status', 'approved');
        $payment->place();

        // Update order status
        //$order->setState($this->getOrderStatus());
        //$order->setStatus($this->getOrderStatus());
        $order->setState("new");
        $order->setStatus("paid_ccn");
        
        //$order->setExtOrderId($params['order_id']);
        $order->save();
        $this->orderSender->send($order);
        
        //commented invoice sent mail functionality
        /*if ($order->canInvoice()) {
            //echo 'invoive';//echo '<pre>';print_r($response);
            // notify customer
            $invoice = $payment->getCreatedInvoice();
            if ($invoice) {
                $this->orderSender->send($order);
                $order->addStatusHistoryComment(
                        __('You notified customer about invoice #%1.', $invoice->getIncrementId())
                )->setIsCustomerNotified(
                        true
                )->save();
            }
        } else {
            // Send email confirmation
            $this->orderSender->send($order);
        }*/
    }

    public function getCgiUrl() {
        $url = $this->getConfigData('sandbox') ?
                $this->getConfigData('cgi_url_sandbox') : $this->getConfigData('cgi_url');
        return $url;
    }

    public function getRedirectUrl() {
        $url = $this->helper->getUrl($this->getConfigData('redirect_url'));
        return $url;
    }

    public function getReturnUrl() {
        $url = $this->helper->getUrl($this->getConfigData('return_url'));
        return $url;
    }

    public function getCancelUrl() {
        $url = $this->helper->getUrl($this->getConfigData('cancel_url'));
        return $url;
    }

    public function getOrderStatus() {
        $value = $this->getConfigData('order_status');
        return $value;
    }

    /*
      public function getApiUrl()
      {
      $url = $this->getConfigData('sandbox') ?
      $this->getConfigData('api_url_sandbox') : $this->getConfigData('api_url');
      return $url;
      }

      public function refund(\Magento\Payment\Model\InfoInterface $payment, $amount)
      {
      if ($amount <= 0) {
      throw new \Magento\Framework\Exception\LocalizedException(__('Invalid amount for refund.'));
      }

      if (!$payment->getParentTransactionId()) {
      throw new \Magento\Framework\Exception\LocalizedException(__('Invalid transaction ID.'));
      }

      $orderNumber = $payment->getAdditionalInformation('tco_order_number');

      $args = array(
      'sale_id' => $orderNumber,
      'category' => 5,
      'comment' => 'Refund issued by merchant.',
      'amount' => $amount,
      'currency' => 'vendor'
      );

      $client = $this->httpClientFactory->create();
      $path = 'sales/refund_invoice';
      $url = $this->getApiUrl();
      $client->setUri($url . $path);
      $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
      $client->setAuth($this->getConfigData('api_user'), $this->getConfigData('api_pass'));

      $client->setHeaders(
      [
      'Accept: application/json'
      ]
      );
      $client->setParameterPost($args);
      $client->setMethod(\Zend_Http_Client::POST);

      try {
      $response = $client->request();
      $responseBody = json_decode($response->getBody(), true);
      if (isset($responseBody['errors'])) {
      $this->_logger->critical(sprintf('Error Refunding Invoice: "%s"', $responseBody['errors'][0]['message']));
      throw new \Magento\Framework\Exception\LocalizedException(__($responseBody['errors'][0]['message']));
      } elseif (!isset($responseBody['response_code']) || !isset($responseBody['response_message'])) {
      throw new \Magento\Framework\Exception\LocalizedException(__('Error refunding transaction.'));
      } elseif ($responseBody['response_code'] != 'OK') {
      throw new \Magento\Framework\Exception\LocalizedException(__($responseBody['response_message']));
      }
      } catch (\Exception $e) {
      throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
      }

      return $this;
      } */
}
