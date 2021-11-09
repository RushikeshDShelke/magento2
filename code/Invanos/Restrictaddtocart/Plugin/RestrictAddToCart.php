<?php

namespace Invanos\Restrictaddtocart\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;

class RestrictAddToCart
{
    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote;

    /**
     * Plugin constructor.
     *
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */

    protected $cart;
    protected $messageManager;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\Message\ManagerInterface $messageManager
    )
    {
        $this->quote = $checkoutSession->getQuote();
        $this->cart = $cart;
        $this->messageManager = $messageManager;
    }

    /**
     * beforeAddProduct
     *
     * @param      $subject
     * @param      $productInfo
     * @param null $requestInfo
     *
     * @return array
     * @throws LocalizedException
     */

    // 
    public function beforeAddProduct($subject, $productInfo, $requestInfo = null)
    {
        $product = $productInfo; // current product data
        $currentProType = $product->getTypeId(); // current product type
        $cartQuote = $this->cart->getQuote(); // get cart
        $cartItems = $cartQuote->getItems(); // get cart items
        $cartItemsCounts = count($cartItems); // count cart items
        $cartItemsArr = []; // create new array for cart items

        if ($cartItemsCounts > 0) // if cart has items
        {
            foreach ($cartItems as $itm)
            {
                $cartItemsArr['product_id'] = $itm->getId();
                $cartItemsArr['product_name'] = $itm->getName();
                $cartItemsArr['product_type'] = $itm->getProductType();
            }
            
            // final custom array for cart items
            $finalCartItemArr = $cartItemsArr;
            // print_r($finalCartItemArr);
            
            // check if amgiftcard is exist in cart
            if (in_array("amgiftcard", $finalCartItemArr))
            {
                // check if the current product IS NOT amgiftcard
                if ($currentProType !== "amgiftcard")
                {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Remove gift card to add product.'));
                }
            }
            else // check if amgiftcard is NOT exist in cart
            {
                // check if the current product IS amgiftcard
                if ($currentProType == "amgiftcard")
                {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Remove product to add gift card.'));
                }
            }
        }

        return [$productInfo, $requestInfo];
    }
}