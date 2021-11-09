<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Cart;


use Magento\Framework\App\ObjectManager;
use Magento\Sitemap\Model\Observer;
use Yosto\Arp\Model\Rule\Form\BlockPosition;

/**
 * Class Crosssell
 * @package Yosto\Arp\Block\Cart
 */
class Crosssell extends \Magento\Checkout\Block\Cart\Crosssell
{

    protected $selectedProductId;

    protected $itemCollection;

    /**
     * Get related products of products in cart
     * if the last added product has related products (base on rule), the system will
     * display related products of this product
     *
     * else the last added product has not related products (base on rule), the system
     * will display related products of the first product which has related products.
     *
     * @return $this|\Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    protected function _prepareData()
    {
        $items = $this->getData('items');
        if ($items === null) {
            $items = [];
            $ninProductIds = $this->_getCartProductIds();
            /** @var \Magento\Catalog\Model\Product $productModel */
            $productModel = ObjectManager::getInstance()->create(
                'Magento\Catalog\Model\Product'
            );
            if ($ninProductIds) {
                $lastAdded = (int)$this->_getLastAddedProductId();
                if ($lastAdded) {
                    $this->setSelectedProductId($lastAdded);
                    $lastAddedProduct = $productModel->load($lastAdded);
                    $this->itemCollection = $lastAddedProduct->getCrossSellProductCollection();
                    /** @var \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility */
                    $this->itemCollection->addAttributeToSelect(
                        'required_options'
                    )->setPositionOrder()->addStoreFilter();
                    // $collection->setPositionOrder()->addStoreFilter();
                    $this->_addProductAttributesAndPrices($this->itemCollection);
                    $this->itemCollection->setVisibility(
                        $this->_productVisibility->getVisibleInCatalogIds()
                    );
                    foreach ($this->itemCollection as $item) {
                        $item->setDoNotUseCategoryId(true);
                    }
                    $this->itemCollection->load();
                    return $this;

                }
                if (!$this->itemCollection || $this->itemCollection->count() == 0) {
                    foreach ($ninProductIds as $ninProductId) {
                       $this->itemCollection = $productModel->load($ninProductId)
                            ->getCrossSellProductCollection();
                            /** @var \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility */
                            $this->itemCollection->addAttributeToSelect(
                                'required_options'
                            )->setPositionOrder()->addStoreFilter();
                            // $collection->setPositionOrder()->addStoreFilter();
                            $this->_addProductAttributesAndPrices($this->itemCollection);
                            $this->itemCollection->setVisibility(
                                $this->_productVisibility->getVisibleInCatalogIds()
                            );
                            $this->setSelectedProductId($ninProductId);
                            foreach ($this->itemCollection as $item) {
                                $item->setDoNotUseCategoryId(true);
                            }
                            $this->itemCollection->load();
                            if ($this->itemCollection->count()) {
                                return $this;
                            }

                    }
                }
            }

        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    public function getItems()
    {
        return $this->itemCollection;
    }

    public function setSelectedProductId($productId) {
        $this->selectedProductId = $productId;
    }

    public  function getBlockMetadata()
    {
        /** @var \Yosto\Arp\Model\ResourceModel\Rule $ruleResource */
        $ruleResource = ObjectManager::getInstance()->create('Yosto\Arp\Model\ResourceModel\Rule');
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = ObjectManager::getInstance()->create('Magento\Customer\Model\Session');
        $customerGroupId = $customerSession->getCustomerGroupId();
        $websiteId = $this->_storeManager->getWebsite()->getId();
        $productId = $this->selectedProductId;

        $matchedRules = $ruleResource->getRulesFromProductByBlockPosition(
            $websiteId,
            $customerGroupId,
            $productId,
            "where_conditions",
            BlockPosition::INSTED_OF_NATIVE_CROSS_SELL_BLOCK
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
                "custom_class" => "yosto_crosssell_product"
            ];
        } else {
            return [];
        }
    }
}