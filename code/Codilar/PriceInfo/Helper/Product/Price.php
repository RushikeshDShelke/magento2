<?php
namespace Codilar\PriceInfo\Helper\Product;

class Price extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Logged In Customer Email Template
     */
    const PRICE_DISPLAY = 'price_tax/general/tax_price_label';

    /**
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;    

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {    
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Return store configuration value
     *
     * @return mixed
     */
    public function getConfigValue()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $priceDisplay = $this->scopeConfig->getValue(self::PRICE_DISPLAY, $storeScope);
        return $priceDisplay;
    }
    
}
