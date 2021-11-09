<?php

namespace Invanos\Conditionalpixel\Block;

use Magento\Checkout\Model\Session;
use Magento\Store\Model\ScopeInterface;

class Cookiedata extends \Magento\Framework\View\Element\Template
{
	/**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @param Session $checkoutSession
 	*/

 	/*
     * ConditionalPixel XML Enable Path
     */
    const XML_PATH_CP_ENABLE = 'invanos_conditionalpixel/general/enable';

    /**
     * Conditional Pixels Name
     */
    const XML_PATH_CP_CONDITIONAL_PIXEL_NAME = 'invanos_conditionalpixel/general/pixel_id';

    /**
     * Conditional Cookie Duration
     */
    const XML_PATH_CP_COOKIE_DURATION = 'invanos_conditionalpixel/general/cookie_duration';


	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		Session $checkoutSession,
		\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
	)
	{
		parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
		$this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
	}

	public function getCookies($name)
	{
	   return $this->_cookieManager->getCookie($name);
	} 

	/**
     * Check if the module is enabled in admin
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_CP_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Conditional Pixel Name
     *
     * @return int
     */
    public function getConditionalPixelName()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_CP_CONDITIONAL_PIXEL_NAME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Conditional Cookie Duration
     *
     * @return int
     */
    public function getCookieDurations()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_CP_COOKIE_DURATION, ScopeInterface::SCOPE_STORE);
    }

	/**
     * Set order
     */
    public function setOrder()
    {
        $this->order = $this->checkoutSession->getLastRealOrder();
    }

    /**
     * Get order
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            $this->setOrder();
        }
        return $this->order;
    }
	

    /**
     * Get the order ID
     *
     * @return string
     */
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }

    /**
     * Get the order total
     */
    public function getGrandTotal()
    {
        return number_format($this->order->getGrandTotal(), 2, '.', '');
    }

    /**
     * Get the shipping amount
     */
    public function getShippingAmount()
    {
        return number_format($this->order->getShippingInclTax(), 2, '.', '');
    }
	
	/**
     * Get the shipping amount
     */
    public function getOrderAmount()
    {
		$ordershippinglesscharge = ($this->order->getGrandTotal() - $this->order->getShippingAmount());
        return number_format($ordershippinglesscharge, 2, '.', '');
    }
}