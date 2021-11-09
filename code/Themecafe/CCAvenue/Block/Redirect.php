<?php

namespace Themecafe\CCAvenue\Block;

class Redirect extends \Magento\Framework\View\Element\Template {

    protected $checkoutsession;
    protected $config;
    protected $_paymentConfig;
    protected $_customerSession;
    protected $_salesFactory;
    protected $orderFactory;
    protected $items = [];

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context, \Themecafe\CCAvenue\Model\Config $config, \Magento\Sales\Model\Order $salesOrderFactory, \Magento\Checkout\Model\Session $checkoutsession, \Magento\Customer\Model\Session $customerSession, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Payment\Model\Config $paymentConfig, array $data = []) {
        parent::__construct($context, $data);
        $this->_paymentConfig = $paymentConfig;
        $this->config = $config;
        $this->checkoutsession = $checkoutsession;
        $this->_customerSession = $customerSession;
        $this->orderFactory = $orderFactory;
        $this->_salesFactory = $salesOrderFactory;
        $this->_isScopePrivate = true;
    }

    public function getQuote() {
        return $this->checkoutsession->getQuote();
    }

    public function getQuoteID() {
        return $this->checkoutsession->getQuoteId();
        ;
    }

    /**
     * Retrieve current order
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function _getOrder() {
        if (!$this->_order) {
            $incrementId = $this->checkoutsession->getLastRealOrderId();
            $this->_order = $this->orderFactory->create()->loadByIncrementId($incrementId);
        }
        return $this->_order;
    }

    public function _setURL($url = '') {
        $this->_url = $this->checkoutsession->getData('iframeURL', true);
    }

    public function _getURL() {
        return $this->checkoutsession->getData('iframeURL', true);
    }

    public function _getToken() {
        return $this->checkoutsession->getData('ccavenueQuoteId');
    }

}
