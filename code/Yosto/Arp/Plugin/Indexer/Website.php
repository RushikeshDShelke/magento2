<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer;

use Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor;

/**
 * Class Website
 * @package Yosto\Arp\Plugin\Indexer
 */
class Website
{
    /**
     * @var RuleProductProcessor
     */
    protected $ruleProductProcessor;

    /**
     * @param RuleProductProcessor $ruleProductProcessor
     */
    public function __construct(RuleProductProcessor $ruleProductProcessor)
    {
        $this->ruleProductProcessor = $ruleProductProcessor;
    }

    /**
     * Invalidate catalog price rule indexer
     *
     * @param \Magento\Store\Model\Website $subject
     * @param \Magento\Store\Model\Website $result
     * @return \Magento\Store\Model\Website
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterDelete(
        \Magento\Store\Model\Website $subject,
        \Magento\Store\Model\Website $result
    ) {
        $this->ruleProductProcessor->markIndexerAsInvalid();
        return $result;
    }
}
