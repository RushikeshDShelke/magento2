<?php
namespace Themecafe\CheckDelivery\Plugin\Payment\Method\CashOnDelivery;

use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Checkout\Model\Cart as Cart;

class Available
{
    protected $backendSession;
    protected $objectManager;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Cart $cart
    )
    {
        $this->objectManager = $objectManager;
        $this->scopeConfig = $scopeConfig;
        $this->cart = $cart;
        $this->backendSession = $this->objectManager->get('\Magento\Backend\Model\Auth\Session');
    }

    public function afterIsAvailable(Cashondelivery $subject, $result)
    {
        if ($this->backendSession->isLoggedIn()) {
            return $result;
        }
        if ($result) {
            return $this->matchCodZip();
        } else {
            return $result;
        }
    }

    public function matchCodZip()
    {
        $cartData = $this->cart->getQuote();
        $zipCode = strtolower($cartData->getShippingAddress()->getData('postcode'));

        $status = $this->scopeConfig->getValue('check_delivery/cod_restriction/active');

        $pindata = $this->scopeConfig->getValue('check_delivery/cod_restriction/zip_code');
        $pindatas = array_map('trim', explode(",", $pindata));
        $pincodearray = array_map('strtolower', $pindatas);
        $return = 1;
        if ($status) {
            if (trim($pindata) != "") {
                if (!in_array($zipCode, $pincodearray)) {
                    $return = 0;
                }
            }
        }
        return $return;
    }

}