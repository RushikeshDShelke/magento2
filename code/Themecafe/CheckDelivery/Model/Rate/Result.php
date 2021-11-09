<?php
namespace Themecafe\CheckDelivery\Model\Rate;

use Magento\Checkout\Model\Cart as Cart;

class Result extends \Magento\Shipping\Model\Rate\Result
{
    protected $objectManager;
    protected $scopeInterface;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Cart $cart
    )
    {
        $this->objectManager = $objectManager;
        $this->scopeInterface = $scopeConfig;
        $this->cart = $cart;
        $this->scopeStore = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $this->scopeWebsite = \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE;
        parent::__construct($storeManager);
    }

    public function append($result)
    {
        if ($result instanceof \Magento\Quote\Model\Quote\Address\RateResult\Error) {
            $this->setError(true);
        }
        if ($result instanceof \Magento\Quote\Model\Quote\Address\RateResult\AbstractResult) {
            $this->_rates[] = $result;
        } elseif ($result instanceof \Magento\Shipping\Model\Rate\Result) {
            $rates = $result->getAllRates();
            foreach ($rates as $rate) {
                $this->append($rate);
            }
        }
        $this->getStatus();
    }
    public function getStatus()
    {
        $pindata = $this->scopeInterface->getValue('check_delivery/general/zip_code', $this->scopeStore);
        $status = $this->scopeInterface->getValue('check_delivery/general/active', $this->scopeStore);
        if ($status && $pindata != "") {
            $productLevelActive = 'check_delivery/general/product_level/product_level_active';
            $productlevelstatus = $this->scopeInterface->getValue($productLevelActive, $this->scopeWebsite);

            $pindatas = array_map('trim', explode(",", $pindata));
            $pincodearray = array_map('strtolower', $pindatas);

            $selectedZipcode = strtolower($this->cart->getQuote()->getShippingAddress()->getPostCode());
            if ($productlevelstatus) {
                $productids = $this->scopeInterface->getValue('check_delivery/general/product_level/product_ids', $this->scopeStore);
                $productidsArr = explode(',', $productids);
                $productidsArr = array_map('trim', $productidsArr);
                $flagTrue = false;
                $flagFalse = true;
                $cart = $this->cart->getQuote()->getAllItems();
                foreach ($cart as $item) {
                    $id = $item->getProduct()->getId();
                    if (in_array($id, $productidsArr)) {
                        if (in_array($selectedZipcode, $pincodearray)) {
                            $flagTrue = true;
                        } else {
                            $flagFalse = false;
                        }
                    } else {
                        $flagTrue = true;
                    }
                }
                if ($flagFalse) {
                    return $this;
                } else {
                    parent::reset();
                }
            } else {
                if (in_array($selectedZipcode, $pincodearray)) {
                    return $this;
                } else {
                    parent::reset();
                }
            }
        } else {
            return $this;
        }
    }
    
}