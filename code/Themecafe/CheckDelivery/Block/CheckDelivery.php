<?php
namespace Themecafe\CheckDelivery\Block;

class CheckDelivery extends \Magento\Framework\View\Element\Template 
{
    protected $scopeConfig;
    protected $customerSession;
    protected $customerAddress;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Address $CustomerAddress,
        array $data
    ) {
        $this->_objectManager = $objectManager;
        $this->_helper = $this->_objectManager->get('Themecafe\CheckDelivery\Helper\Data');
        $this->scopeConfig = $context->getScopeConfig();
        $this->registry = $registry;
        $this->customerSession = $customerSession;
        $this->customerAddress = $CustomerAddress;
        
        parent::__construct($context, $data);
    }
    public function getHelper()
    {
        return $this->_helper;
    }
    public function getScopeConfig()
    {
        return $this->scopeConfig;
    }
    public function getRegistry()
    {
        return $this->registry;
    }
    public function getCustomerSession()
    {
        return $this->customerSession;
    }

    public function getDefaultShippingZipcode() 
    {
        if ($this->customerSession->isLoggedIn()) {
            $shippingId = $this->customerSession->getCustomer()->getDefaultShipping();
            if ($shippingId) {
                $address = $this->customerAddress->load($shippingId);
                return $address->getPostcode();
            }
        }
        return "";
    }

}