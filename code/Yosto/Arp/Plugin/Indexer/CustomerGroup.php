<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer;

use Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor;
use Magento\Customer\Model\Group;

/**
 * Class CustomerGroup
 * @package Yosto\Arp\Plugin\Indexer
 */
class CustomerGroup
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
     * @param Group $subject
     * @param Group $result
     * @return Group
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterDelete(
        Group $subject,
        Group $result
    ) {
        $this->ruleProductProcessor->markIndexerAsInvalid();
        return $result;
    }
}
