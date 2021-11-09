<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Plugin\Model;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\StoreManagerInterface;
use Yosto\Arp\Model\ResourceModel\Rule as RuleResource;
use Yosto\Arp\Model\Rule\Form\BlockPosition;
use Yosto\Arp\Model\ResourceModel\WhatProduct\CollectionFactory as WhatProductCollectionFactory;
use Yosto\Arp\Model\ResourceModel\WhatProduct as WhatProductResource;
use Magento\Catalog\Model\ResourceModel\Product\Link\Product\CollectionFactory as ProductCollectionFactory;
use Yosto\Arp\Model\Rule\Form\SortBy;

/**
 * Class Product
 * @package Yosto\Arp\Plugin\Model
 */
class Product
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var RuleResource
     */
    protected $ruleResource;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var WhatProductCollectionFactory
     */
    protected $whatProductCollectionFactory;

    /**
     * @var WhatProductResource
     */
    protected $whatProductResource;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * Product constructor.
     * @param CustomerSession $session
     * @param RuleResource $ruleResource
     * @param StoreManagerInterface $storeManager
     * @param WhatProductCollectionFactory $whatProductCollectionFactory
     * @param WhatProductResource $whatProductResource
     * @param ProductCollectionFactory $productCollectionFactory
     */
    public function __construct(
        CustomerSession $session,
        RuleResource $ruleResource,
        StoreManagerInterface $storeManager,
        WhatProductCollectionFactory $whatProductCollectionFactory,
        WhatProductResource $whatProductResource,
        ProductCollectionFactory $productCollectionFactory
    )
    {
        $this->customerSession = $session;
        $this->ruleResource = $ruleResource;
        $this->storeManager = $storeManager;
        $this->whatProductCollectionFactory = $whatProductCollectionFactory;
        $this->whatProductResource = $whatProductResource;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function modifyResult(
        \Magento\Catalog\Model\Product $subject,
        $websiteId,
        $customerGroupId,
        $matchedRules
    ) {
        $ruleWithHighestPriority = 0;
        $sortOrder = $matchedRules[0]['sort_order'];
        $maxProducts = 0;
        $sortBy = SortBy::BEST_SELLER;
        foreach ($matchedRules as $matchedRule) {
            if ($matchedRule['sort_order'] <= $sortOrder ) {
                $sortOrder = $matchedRule['sort_order'];
                $ruleWithHighestPriority = $matchedRule['rule_id'];
                $maxProducts = $matchedRule['max_products'];
                $sortBy = (int) $matchedRule['sort_by'];
            }
        }

        $whatProductTable = $this->ruleResource->getTable(
            'yosto_arp_rule_what_product'
        );
        $ratingOptionVoteTable = $this->ruleResource->getTable(
          "rating_option_vote_aggregated"
        );

        $reportViewedProductTable = $this->ruleResource->getTable(
            'report_viewed_product_aggregated_daily'
        );

        $salesBestsellersTable = $this->ruleResource->getTable(
            'sales_bestsellers_aggregated_daily'
        );
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->getSelect()
            ->distinct()
            ->join(
                $whatProductTable . " as wp",
                "e.entity_id = wp.product_id",
                []
            )
            ->where('e.entity_id <> ' . $subject->getId())
            ->where('wp.website_id =' . $websiteId)
            ->where('wp.customer_group_id = ' . $customerGroupId)
            ->where('wp.rule_id ='. $ruleWithHighestPriority);
        if ($sortBy == SortBy::BEST_SELLER) {
           $productCollection->getSelect()
               ->distinct()
               ->joinLeft(
                   $salesBestsellersTable . " as sbt",
                   'e.entity_id = sbt.product_id',
                   [
                       'total_ordered' => "sum(sbt.qty_ordered)"
                   ]
               )
               ->group('e.entity_id')
               ->order('total_ordered DESC') ;
        } elseif ($sortBy == SortBy::BEST_RATED) {
            $productCollection->getSelect()
                ->joinLeft(
                    $ratingOptionVoteTable . " as rovt",
                    'e.entity_id = rovt.entity_pk_value',
                    [

                    ]
                )->order('rovt.percent_approved DESC');
        } elseif ($sortBy == SortBy::MOST_VIEWED) {
            $productCollection->getSelect()
                ->joinLeft(
                    $reportViewedProductTable . " as rvp",
                    'e.entity_id = rvp.product_id',
                    [
                        'total_views' => "sum(rvp.views_num)"
                    ]
                )
                ->group('e.entity_id')
                ->order('total_views DESC') ;
        }
        $result = $productCollection->setPage(0, $maxProducts);
        $result->setProduct($subject);
        return $result;
    }

    public function afterGetRelatedProductCollection(
        \Magento\Catalog\Model\Product $subject,
        $result
    ) {
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $websiteId = $this->storeManager->getWebsite()->getId();
        $matchedRules = $this->ruleResource->getRulesFromProductByBlockPosition(
            $websiteId,
            $customerGroupId,
            $subject->getId(),
            "where_conditions",
            BlockPosition::INSTEAD_OF_NATIVE_RELATED_BLOCK
        );

        if ($matchedRules && count($matchedRules) > 0) {

            $result = $this->modifyResult(
                $subject,
                $websiteId,
                $customerGroupId,
                $matchedRules
            );

        }

        return $result;

    }

    public function afterGetUpSellProductCollection(
        \Magento\Catalog\Model\Product $subject,
        $result
    ) {

        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $websiteId = $this->storeManager->getWebsite()->getId();
        $matchedRules = $this->ruleResource->getRulesFromProductByBlockPosition(
            $websiteId,
            $customerGroupId,
            $subject->getId(),
            "where_conditions",
            BlockPosition::INSTEAD_OF_NATIVE_UP_SELL_BLOCK
        );


        if ($matchedRules && count($matchedRules) > 0) {
            $result = $this->modifyResult(
                $subject,
                $websiteId,
                $customerGroupId,
                $matchedRules
            );

        }

        return $result;
    }

    public function afterGetCrossSellProductCollection(
        \Magento\Catalog\Model\Product $subject,
        $result
    ) {
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $websiteId = $this->storeManager->getWebsite()->getId();
        $matchedRules = $this->ruleResource->getRulesFromProductByBlockPosition(
            $websiteId,
            $customerGroupId,
            $subject->getId(),
            "where_conditions",
            BlockPosition::INSTED_OF_NATIVE_CROSS_SELL_BLOCK
        );


        if ($matchedRules && count($matchedRules) > 0) {

            $result = $this->modifyResult(
                $subject,
                $websiteId,
                $customerGroupId,
                $matchedRules
            );

        }

        return $result;
    }
}