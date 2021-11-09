<?php

namespace Themecafe\CCAvenue\Controller\Ccavenue;

class Cancel extends \Themecafe\CCAvenue\Controller\Checkout
{

    public function execute()
    {
        $this->_cancelPayment();
        $this->_checkoutSession->restoreQuote();
        $this->getResponse()->setRedirect(
            $this->getCheckoutHelper()->getUrl('checkout')
        );
    }

}
