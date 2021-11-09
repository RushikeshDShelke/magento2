<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule;
use Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor;

/**
 * Class Job
 * @package Yosto\Arp\Model\Rule
 */
class Job extends \Magento\Framework\DataObject
{
    /**
     * @var RuleProductProcessor
     */
    protected $ruleProcessor;

    /**
     * Basic object initialization
     *
     * @param RuleProductProcessor $ruleProcessor
     */
    public function __construct(RuleProductProcessor $ruleProcessor)
    {
        $this->ruleProcessor = $ruleProcessor;
    }

    /**
     * Dispatch event "yosto_arp_apply_all" and set success or error message depends on result
     *
     * @return \Magento\CatalogRule\Model\Rule\Job
     * @api
     */
    public function applyAll()
    {
        try {
            $this->ruleProcessor->markIndexerAsInvalid();
            $this->setSuccess(__('Updated rules applied.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->setError($e->getMessage());
        }
        return $this;
    }
}