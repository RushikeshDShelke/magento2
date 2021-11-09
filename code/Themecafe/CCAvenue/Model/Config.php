<?php

namespace Themecafe\CCAvenue\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config {

    const CCAVENUE_ACTIVE = 'payment/ccavenue/active';
    const CCAVENUE_TITLE = 'payment/ccavenue/title';
    const CCAVENUE_MERCHANT_ID = 'payment/ccavenue/merchant_id';
    const CCAVENUE_MERCHANT_ACCESS_CODE = 'payment/ccavenue/access_code';
    const CCAVENUE_TRANS_KEY = 'payment/ccavenue/api_key';
    const CCAVENUE_TEST = 'payment/ccavenue/sandbox';
    const CCAVENUE_DEBUG = 'payment/ccavenue/record_logs';
    const CCAVENUE_GATEWAY_URL = 'payment/ccavenue/cgi_url';
    const CCAVENUE_TEST_GATEWAY_URL = 'payment/ccavenue/cgi_url_sandbox';
    const CCAVENUE_NEW_ORDER_STATUS = 'payment/ccavenue/order_status';
    const CCAVENUE_VALIDATION_NONE = 'none';
    const CCAVENUE_VALIDATION_TEST = 'testMode';
    const CCAVENUE_VALIDATION_LIVE = 'liveMode';
    const CCAVENUE_INTEGRATION_TECHNIQUE = 'payment/ccavenue/integration_technique';

    protected $_storeId = null;
    protected $_backend = false;
    protected $_coreRegistry = null;
    protected $_session;
    protected $_adminsession;
    protected $scopeConfig;
    protected $encryptor;
    protected $_order;
    protected $_url;

    public function __construct(
    \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Registry $registry, \Magento\Framework\UrlInterface $urlInterface, \Magento\Backend\Model\Session\Quote $quoteSession, \Magento\Backend\Model\Session $adminsession, \Magento\Framework\Encryption\Encryptor $encryptor, ScopeConfigInterface $scopeConfig, \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformation, array $data = []
    ) {

        $this->_storeManager = $storeManager;
        $this->_coreRegistry = $registry;
        $this->_session = $quoteSession;
        $this->_adminsession = $adminsession;
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
        $this->_url = $urlInterface;
	$this->countryInformation = $countryInformation;
        $this->_backend = false;

        if ($this->_backend && $this->_coreRegistry->registry('current_order') != false) {
            $this->setStoreId($this->_coreRegistry->registry('current_order')->getStoreId());
            $this->_adminsession->setCustomerStoreId(null);
        } elseif ($this->_backend && $this->_coreRegistry->registry('current_invoice') != false) {
            $this->setStoreId($this->_coreRegistry->registry('current_invoice')->getStoreId());
            $this->_adminsession->setCustomerStoreId(null);
        } elseif ($this->_backend && $this->_coreRegistry->registry('current_creditmemo') != false) {
            $this->setStoreId($this->_coreRegistry->registry('current_creditmemo')->getStoreId());
            $this->_adminsession->setCustomerStoreId(null);
        } elseif ($this->_backend && $this->_coreRegistry->registry('current_customer') != false) {
            $this->setStoreId($this->_coreRegistry->registry('current_customer')->getStoreId());
            $this->_adminsession->setCustomerStoreId($this->_coreRegistry->registry('current_customer')->getStoreId());
        } elseif ($this->_backend && $this->_session->getStore()->getId() > 0) {
            $this->setStoreId($this->_session->getStore()->getId());
            $this->_adminsession->setCustomerStoreId(null);
        } else {
            $customerStoreSessionId = null;
            if ($this->_backend && $customerStoreSessionId != null) {
                $this->setStoreId($customerStoreSessionId);
            } else {
                $this->setStoreId($this->_storeManager->getStore()->getId());
            }
        }
    }

    public function setStoreId($storeId = 0) {
        $this->_storeId = $storeId;

        return $this;
    }

    public function getStoreId() {
        return $this->_storeId;
    }

    public function getConfigData($field, $storeId = null) {
        return $this->scopeConfig->getValue($field, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getIsActive() {
        return $this->getConfigData(self::CCAVENUE_ACTIVE, $this->_storeId);
    }

    /**
     * This method will return whether test mode is enabled or not.
     *
     * @return bool
     */
    public function getIsTestMode() {
        return $this->getConfigData(self::CCAVENUE_TEST, $this->_storeId);
    }

    /**
     * This metod will return CCAVENUE Gateway url depending on test mode enabled or not.
     *
     * @return string
     */
    public function getGatewayUrl() {
        $isTestMode = $this->getIsTestMode();
        $gatewayUrl = null;
        $gatewayUrl = ($isTestMode) ? $this->getConfigData(self::CCAVENUE_TEST_GATEWAY_URL, $this->_storeId) : $this->getConfigData(self::CCAVENUE_GATEWAY_URL, $this->_storeId);

        return $gatewayUrl;
    }

    /**
     * This methos will return Cybersource payment method title set by admin to display on onepage checkout payment step.
     *
     * @return string
     */
    public function getMethodTitle() {
        return (string) $this->getConfigData(self::CCAVENUE_TITLE, $this->_storeId);
    }

    /**
     * This method will return merchant api login id set by admin in configuration. 
     *
     * @return string
     */
    public function getAccessCode() {
        return (string) $this->getConfigData(self::CCAVENUE_MERCHANT_ACCESS_CODE, $this->_storeId);
    }

    /**
     * This method will return merchant api login id set by admin in configuration. 
     *
     * @return string
     */
    public function getMerchantId() {
        return (string) $this->getConfigData(self::CCAVENUE_MERCHANT_ID, $this->_storeId);
    }

    /**
     * This method will return merchant api transaction key set by admin in configuration.
     *
     * @return string
     */
    public function getWorkingKey() {
        return (string) ($this->getConfigData(self::CCAVENUE_TRANS_KEY, $this->_storeId));
    }

    /**
     * This method will return integration technique set by admin in configuration.
     *
     * @return string
     */
    public function getIntegrationTechnique() {
        return (string) ($this->getConfigData(self::CCAVENUE_INTEGRATION_TECHNIQUE, $this->_storeId));
    }

    /**
     * This will returne payment action whether it is authorized or authorize and capture.
     *
     * @return string
     */
    public function getPaymentAction() {
        return (string) $this->getConfigData(self::CCAVENUE_PAYMENT_ACTION, $this->_storeId);
    }

    /**
     * This method will return whether debug is enabled from config.
     *
     * @return bool
     */
    public function getIsDebugEnabled() {
        return (boolean) $this->getConfigData(self::CCAVENUE_DEBUG, $this->_storeId);
    }

    public function getDefaultFormat() {
        return $this->getConfigData('customer/address_templates/html', $this->_storeId);
    }

    public function getCheckoutFormFields($order) {

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();
	$billingCountry = $this->countryInformation->getCountryInfo($billingAddress->getCountryId())->getFullNameLocale();

        if (!$shippingAddress)
            $shippingAddress = $billingAddress;

        $streets = $billingAddress->getStreet();
        $bstreet = isset($streets[0]) && $streets[0] != '' ? $streets[0] : (isset($streets[1]) && $streets[1] != '' ? $streets[1] : '');

        if ($shippingAddress)
            $streets = $shippingAddress->getStreet();
        $street = isset($streets[0]) && $streets[0] != '' ? $streets[0] : (isset($streets[1]) && $streets[1] != '' ? $streets[1] : '');

        if ($order->getCustomerEmail()) {
            $email = $order->getCustomerEmail();
        } elseif ($billingAddress->getEmail()) {
            $email = $billingAddress->getEmail();
        } else {
            $email = '';
        }
        $merchantId = $this->getMerchantId();
        $accessCode = $this->getAccessCode();
        $working_key = $this->getWorkingKey();
//        $orderID = $order->getReservedOrderId();
        $orderID = $order->getRealOrderId();

        $amount = number_format($order->getBaseGrandTotal(), 2, '.', "");
        $returnURL = $this->_storeManager->getStore()->getUrl('ccavenue/ccavenue/response', array('_secure' => true));
        $cancelURL = $this->_storeManager->getStore()->getUrl('ccavenue/ccavenue/cancel', array('_secure' => true));

        /* $fields = array(
          'Merchant_Id' => $merchantId,
          'WorkingKey' => $accessCode,
          'Currency' => 'INR',
          'TxnType' => 'A',
          'actionID' => 'TXN',
          'Order_Id' => $orderID,
          'Amount' => $amount,
          'Redirect_Url' =>$returnURL,
          'description' => 'Order '. $orderID,
          'billing_cust_name' => $billingAddress->getFirstname(),
          'billing_last_name' => $billingAddress->getLastname(),
          'billing_cust_address' => $billling[0] ,
          'billing_cust_city' => $billingAddress->getCity(),
          'billing_cust_state' => $billingAddress->getRegionCode(),
          'billing_zip_code' => $billingAddress->getPostcode(),
          'billing_cust_country' => $billingAddress->getCountryModel()->getName(),
          'billing_cust_tel_no' => $billingAddress->getTelephone(),
          'billing_cust_email' => $email,
          'delivery_cust_name' => $shippingAddress->getFirstname(),
          'delivery_last_name' => $shippingAddress->getLastname(),
          'delivery_cust_address' => $shipping[0],
          'delivery_cust_city' => $shippingAddress->getCity(),
          'delivery_cust_state' => $shippingAddress->getRegionCode(),
          'delivery_zip_code' => $shippingAddress->getPostcode(),
          'delivery_cust_country' => $shippingAddress->getCountryModel()->getName(),
          'delivery_cust_tel_no' => $shippingAddress->getTelephone(),
          'cb_url' => '',
          'cb_type' => 'P',
          'cs1' => $orderID,
          'Checksum' => $this->getCheckSum($merchantId, $amount, $orderID, $returnURL, $accessCode),
          );

          return $fields; */

        //REDIRECTION CODE
        $merchant_data = 'tid=' . urlencode(date('his'))
                . '&merchant_id=' . urlencode($merchantId)
                . '&order_id=' . urlencode($orderID)
                . '&amount=' . urlencode($amount)
                . "&currency=INR"
                . '&redirect_url=' . urlencode($returnURL)
                . '&cancel_url=' . urlencode($returnURL)
                . '&language=EN'
                . '&billing_name=' . urlencode(substr($billingAddress->getFirstname() . " " . $billingAddress->getLastname(), 0, 60))
                . '&billing_address=' . urlencode(substr($bstreet, 0, 150))
                . '&billing_city=' . urlencode(substr($billingAddress->getCity(), 0, 30))
                . '&billing_state=' . urlencode($billingAddress->getRegion())
                . '&billing_zip=' . urlencode($billingAddress->getPostcode())
                . '&billing_country=' . urlencode($billingCountry)
                . '&billing_tel=' . urlencode($billingAddress->getTelephone())
                . '&billing_email=' . urlencode($email)
                . '&delivery_name=' . urlencode(substr($shippingAddress->getFirstname() . " " . $shippingAddress->getLastname(), 0, 60))
                . '&delivery_address=' . urlencode(substr($street, 0, 150))
                . '&delivery_city=' . urlencode(substr($shippingAddress->getCity(), 0, 30))
                . '&delivery_state=' . urlencode($shippingAddress->getRegion())
                . '&delivery_zip=' . urlencode($shippingAddress->getPostcode())
                . '&delivery_country=' . urlencode($shippingAddress->getCountryId())
                . '&delivery_tel=' . urlencode($shippingAddress->getTelephone())
                . '&merchant_param1=&merchant_param2=&merchant_param3=&merchant_param4='
                . '&merchant_param5=&'
                . 'promo_code=&customer_identifier=&';
        if ($this->getIntegrationTechnique() != 'redirect') {
            $merchant_data.='integration_type=iframe_normal&';
        } 
        
        if ($this->getIsDebugEnabled()) {
            $this->recordLog('REQUEST : ' . $merchant_data);
        }
        $merchant_data = $this->encrypt($merchant_data, $working_key);
        return array('encRequest' => $merchant_data, 'access_code' => $accessCode);
    }

    public function decryptResponse($response) {

        $rcvdString = $this->decrypt($response, $this->getWorkingKey());

        $decryptValues = explode('&', $rcvdString);
        $response_array = array();

        for ($i = 0; $i < count($decryptValues); $i++) {
            $information = explode('=', $decryptValues[$i]);
            if (count($information) == 2) {
                $response_array[$information[0]] = $information[1];
            }
        }
        return $response_array;
    }

    public function getchecksum($MerchantId, $Amount, $OrderId, $URL, $WorkingKey) {
        return $this->genChecksum("$MerchantId|$OrderId|$Amount|$URL|$WorkingKey");
    }

    /* CCAVENUE CORE FUNCTIONS STARTED */

    public function genChecksum($str) {
        $adler = 1;
        $adler = $this->adler32($adler, $str);
        return $adler;
    }

    public function verifyChecksum($getCheck, $avnChecksum) {
        $verify = false;
        if ($getCheck == $avnChecksum)
            $verify = true;
        return $verify;
    }

    private function adler32($adler, $str) {
        $BASE = 65521;
        $s1 = $adler & 0xffff;
        $s2 = ($adler >> 16) & 0xffff;
        for ($i = 0; $i < strlen($str); $i++) {
            $s1 = ($s1 + Ord($str[$i])) % $BASE;
            $s2 = ($s2 + $s1) % $BASE;
        }
        return $this->leftshift($s2, 16) + $s1;
    }

    private function leftshift($str, $num) {

        $str = DecBin($str);

        for ($i = 0; $i < (64 - strlen($str)); $i++)
            $str = "0" . $str;

        for ($i = 0; $i < $num; $i++) {
            $str = $str . "0";
            $str = substr($str, 1);
            //echo "str : $str <BR>";
        }
        return $this->cdec($str);
    }

    private function cdec($num) {
        $dec = 0;
        for ($n = 0; $n < strlen($num); $n++) {
            $temp = $num[$n];
            $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
        }

        return $dec;
    }

    public function encrypt($plainText, $key) {
        $secretKey = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);

        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $plainPad = $this->pkcs5_pad($plainText, $blockSize);

        if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
            $encryptedText = mcrypt_generic($openMode, $plainPad);
            mcrypt_generic_deinit($openMode);
        }

        return bin2hex($encryptedText);
    }

    public function decrypt($encryptedText, $key) {
        $secretKey = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);

        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');

        mcrypt_generic_init($openMode, $secretKey, $initVector);
        $decryptedText = mdecrypt_generic($openMode, $encryptedText);

        $decryptedText = rtrim($decryptedText, "\0");

        mcrypt_generic_deinit($openMode);

        return $decryptedText;
    }

    private function pkcs5_pad($plainText, $blockSize) {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    private function hextobin($hexString) {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString.=$packedString;
            }

            $count+=2;
        }
        return $binString;
    }

    public function recordLog($message_log) {
        // log exception to exceptions log
        $message = 'Response message: ' . $message_log;
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/ccavenue.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($message);
    }

}

