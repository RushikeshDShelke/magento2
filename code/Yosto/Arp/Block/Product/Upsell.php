<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Product;


use Magento\Framework\App\ObjectManager;
use Yosto\Arp\Model\Rule\Form\BlockPosition;

/**
 * Class Upsell
 * @package Yosto\Arp\Block\Product
 */
class Upsell extends \Magento\Catalog\Block\Product\ProductList\Upsell
{
    /**
     * @return array
     */
    public  function getBlockMetadata()
    {
        /** @var \Yosto\Arp\Model\ResourceModel\Rule $ruleResource */
        $ruleResource = ObjectManager::getInstance()->create('Yosto\Arp\Model\ResourceModel\Rule');
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = ObjectManager::getInstance()->create('Magento\Customer\Model\Session');
        $customerGroupId = $customerSession->getCustomerGroupId();
        $websiteId = $this->_storeManager->getWebsite()->getId();
        $productId = $this->getProduct()->getId();

        $matchedRules = $ruleResource->getRulesFromProductByBlockPosition(
            $websiteId,
            $customerGroupId,
            $productId,
            "where_conditions",
            BlockPosition::INSTEAD_OF_NATIVE_UP_SELL_BLOCK
        );

        $blockTitle = "";
        $layoutType = "";
        $showCartButton = false;
        if ($matchedRules && count($matchedRules) > 0) {

            $highestPriority = $matchedRules[0]['sort_order'];
            foreach ($matchedRules as $matchedRule) {
                if ($matchedRule['sort_order'] <= $highestPriority) {
                    $highestPriority = $matchedRule['sort_order'];
                    $blockTitle = $matchedRule['block_title'];
                    $layoutType = $matchedRule['layout'];
                    $showCartButton = (boolean) $matchedRule['show_cart_button'];
                }
            }

            return [
                "block_title" => $blockTitle,
                "layout_type" => $layoutType,
                "show_cart_button" => $showCartButton,
                "custom_class" => "yosto_upsell_product"
            ];
        } else {
            return [];
        }
    }
}