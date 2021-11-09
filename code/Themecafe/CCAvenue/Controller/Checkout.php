<?php

namespace Themecafe\CCAvenue\Controller;

abstract class Checkout extends \Magento\Framework\App\Action\Action {

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $_quote;

    /**
     * @var \Themecafe\CCAvenue\Model\Checkout
     */
    protected $_paymentMethod;

    /**
     * @var \Themecafe\CCAvenue\Helper\Checkout
     */
    protected $_checkoutHelper;

    /**
     * @var \Themecafe\CCAvenue\Model\Config
     */
    protected $_config;

    /**
     * @var \Magento\Quote\Api\CartManagementInterface
     */
    protected $cartManagement;

    /**
     * @var \Magento\Framework\Controller\Result\PageFactory $resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * Logging instance
     * @var \Themecafe\CCAvenue\Logger\Logger
     */
    protected $_cclogger;

    /**
     * Logging instance
     * @var \Magento\Quote\Model\QuoteManagement
     */
    protected $quoteManagement;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Themecafe\CCAvenue\Model\CCAvenue $paymentMethod
     * @param \Themecafe\CCAvenue\Helper\Checkout $checkoutHelper
     * @param \Magento\Quote\Api\CartManagementInterface $cartManagement
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Themecafe\CCAvenue\Logger $logger
     * @param \Magento\Quote\Model\QuoteManagement $quoteManagement
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, 
            \Magento\Customer\Model\Session $customerSession, 
            \Magento\Checkout\Model\Session $checkoutSession, 
            \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, 
            \Magento\Sales\Model\OrderFactory $orderFactory, 
            \Psr\Log\LoggerInterface $logger, 
            \Themecafe\CCAvenue\Model\CCAvenue $paymentMethod, 
            \Themecafe\CCAvenue\Helper\Checkout $checkoutHelper, 
            \Themecafe\CCAvenue\Model\Config $_config, 
            \Magento\Quote\Api\CartManagementInterface $cartManagement, 
            \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
            \Themecafe\CCAvenue\Logger\Logger $cclogger, 
            \Magento\Quote\Model\QuoteManagement $quoteManagement
    ) {
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->_orderFactory = $orderFactory;
        $this->_paymentMethod = $paymentMethod;
        $this->_checkoutHelper = $checkoutHelper;
        $this->_config = $_config;
        $this->cartManagement = $cartManagement;
        $this->resultPageFactory = $resultPageFactory;
        $this->_logger = $logger;
        $this->_cclogger = $cclogger;
        $this->quoteManagement = $quoteManagement;
        parent::__construct($context);
    }

    /**
     * Instantiate quote and checkout
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function initCheckout() {
        $quote = $this->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->getResponse()->setStatusHeader(403, '1.1', 'Forbidden');
            throw new \Magento\Framework\Exception\LocalizedException(__('We can\'t initialize checkout.'));
        }
    }

    /**
     * Cancel order, return quote to customer
     *
     * @param string $errorMsg
     * @return false|string
     */
    protected function _cancelPayment($errorMsg = '') {
        $gotoSection = false;
        $this->_checkoutHelper->cancelCurrentOrder($errorMsg);
        if ($this->_checkoutSession->restoreQuote()) {
            //Redirect to payment step
            $gotoSection = 'paymentMethod';
        }
        
        return $gotoSection;
    }

    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getOrderById($order_id) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order');
        $order_info = $order->loadByIncrementId($order_id);
        return $order_info;
    }
    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getQuoteById($quoteId) {
       
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $quote = $objectManager->get('Magento\Quote\Model\Quote')->loadByIdWithoutStore($quoteId);
        return $quote;
    }

    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getOrder() {
        return $this->_orderFactory->create()->loadByIncrementId(
                        $this->_checkoutSession->getLastRealOrderId()
        );
    }

    protected function getQuote() {
        if (!$this->_quote) {
            $this->_quote = $this->getCheckoutSession()->getQuote();
        }
        return $this->_quote;
    }

    protected function getCheckoutSession() {
        return $this->_checkoutSession;
    }

    public function getCustomerSession() {
        return $this->_customerSession;
    }

    public function getPaymentMethod() {
        return $this->_paymentMethod;
    }

    public function getCheckoutConfig() {
        return $this->_config;
    }

    protected function getCheckoutHelper() {
        return $this->_checkoutHelper;
    }

}
