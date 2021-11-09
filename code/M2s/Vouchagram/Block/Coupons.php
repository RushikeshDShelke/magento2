<?php

namespace M2s\Vouchagram\Block;

class Coupons extends \Magento\Checkout\Block\Cart\AbstractCart
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    /**
     * @var \Amasty\GiftCard\Model\ResourceModel\Quote\CollectionFactory
     */
    private $giftQuoteCollectionFactory;
    /**
     * @var \Amasty\GiftCard\Helper\Data
     */
    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnableGiftFormInCart()
    {
        return true;
    }

     public function getCouponsFromSession()
    {
        $appliedCoupons = $this->_checkoutSession->getCouponInfo();
        return $appliedCoupons;
    }

    public function getIsEnabled() {
        return $this->scopeConfig->getValue('coupon/general_settings/status',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
