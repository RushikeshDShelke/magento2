<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer;

use Yosto\Arp\Model\Indexer\Product\ProductRuleProcessor;

/**
 * Class Category
 * @package Yosto\Arp\Plugin\Indexer
 */
class Category
{
    /**
     * @var ProductRuleProcessor
     */
    protected $productRuleProcessor;

    /**
     * @param ProductRuleProcessor $productRuleProcessor
     */
    public function __construct(
        ProductRuleProcessor $productRuleProcessor
    ) {
        $this->productRuleProcessor = $productRuleProcessor;
    }

    /**
     * @param \Magento\Catalog\Model\Category $subject
     * @param \Magento\Catalog\Model\Category $result
     * @return \Magento\Catalog\Model\Category
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        \Magento\Catalog\Model\Category $subject,
        \Magento\Catalog\Model\Category $result
    ) {
        /** @var \Magento\Catalog\Model\Category $result */
        $productIds = $result->getAffectedProductIds();
        if ($productIds) {
            $this->productRuleProcessor->reindexList($productIds);
        }
        return $result;
    }

    /**
     * @param \Magento\Catalog\Model\Category $subject
     * @param \Magento\Catalog\Model\Category $result
     * @return \Magento\Catalog\Model\Category
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterDelete(
        \Magento\Catalog\Model\Category $subject,
        \Magento\Catalog\Model\Category $result
    ) {
        $this->productRuleProcessor->markIndexerAsInvalid();
        return $result;
    }
}
