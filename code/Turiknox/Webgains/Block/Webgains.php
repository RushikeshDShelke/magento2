<?php
/*
 * Turiknox_Webgains

 * @category   Turiknox
 * @package    Turiknox_Webgains
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento2-webgains-tracking/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\Webgains\Block;

use Magento\Checkout\Model\Session;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

use Magento\Framework\Stdlib\CookieManagerInterface;

class Webgains extends Template
{
	/**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
	
	protected $_cookieManager;	
	
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var Resolver
     */
    protected $locale;

    /*
     * Webgains XML Enable Path
     */
    const XML_PATH_WG_ENABLE = 'webgains/general/enable';

    /**
     * Webgains Program ID
     */
    const XML_PATH_WG_PROGRAM_ID = 'webgains/general/program_id';

    /**
     * Webgains Event ID
     */
    const XML_PATH_WG_EVENT_ID = 'webgains/general/event_id';

    /**
     * Webgains Version
     */
    const WG_VERSION = '1.2';

    /**
     * Webgains constructor.
     *
     * @param Context $context
     * @param Session $checkoutSession
     * @param Resolver $locale
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        Resolver $locale,
		\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
		\Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
		$this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->locale = $locale;
		$this->_cookieManager = $cookieManager;
    }
	
	/**
    * Return current product instance
    *
    * @return \Magento\Catalog\Model\Product
    */
    public function getProduct()
    {
        return $this->coreRegistry->registry('product');
    }
	
	/**
     * Return catalog current category object
     *
     * @return \Magento\Catalog\Model\Category
     */

    public function getCurrentCategory()
    {
        return $this->coreRegistry->registry('current_category');
    }

	public function getCookie($name)
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
        return $this->_scopeConfig->getValue(self::XML_PATH_WG_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Webgains Program ID
     *
     * @return int
     */
    public function getWebgainsProgramId()
    {
        //return $this->_scopeConfig->getValue(self::XML_PATH_WG_PROGRAM_ID, ScopeInterface::SCOPE_STORE);
        return "ProNdsl1234";
    }

    /**
     * Get Webgains Event ID
     *
     * @return int
     */
    public function getWebgainsEventId()
    {
        //return $this->_scopeConfig->getValue(self::XML_PATH_WG_EVENT_ID, ScopeInterface::SCOPE_STORE);
        return "ndslEve1234";
    }

    /**
     * Get current locale
     *
     * @return null|string
     */
    public function getLocaleCode()
    {
        return $this->locale->getLocale();
    }

    /**
     * Get Webgains Version
     *
     * @return string
     */
    public function getWebgainsVersion()
    {
        return self::WG_VERSION;
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
