<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer;

use Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor;
use Magento\ImportExport\Model\Import;

/**
 * Class ImportExport
 * @package Yosto\Arp\Plugin\Indexer
 */
class ImportExport
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
     * @param Import $subject
     * @param bool $result
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterImportSource(Import $subject, $result)
    {
        if (!$this->ruleProductProcessor->isIndexerScheduled()) {
            $this->ruleProductProcessor->markIndexerAsInvalid();
        }
        return $result;
    }
}
