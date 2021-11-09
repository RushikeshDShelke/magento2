<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer\Product\Save;

use Yosto\Arp\Model\Indexer\Product\ProductRuleProcessor;

/**
 * Class ApplyRulesAfterReindex
 * @package Yosto\Arp\Plugin\Indexer\Product\Save
 */
class ApplyRulesAfterReindex
{
    /**
     * @var ProductRuleProcessor
     */
    protected $productRuleProcessor;

    /**
     * @param ProductRuleProcessor $productRuleProcessor
     */
    public function __construct(ProductRuleProcessor $productRuleProcessor)
    {
        $this->productRuleProcessor = $productRuleProcessor;
    }

    /**
     * Apply catalog rules after product resource model save
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param callable $proceed
     * @return \Magento\Catalog\Model\Product
     */
    public function aroundReindex(
        \Magento\Catalog\Model\Product $subject,
        callable $proceed
    ) {
        $proceed();
        $this->productRuleProcessor->reindexRow($subject->getId());
        return;
    }
}
