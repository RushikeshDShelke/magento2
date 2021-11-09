<?php
/**
 * Created by PhpStorm.
 * User: nghiata
 * Date: 24/07/2017
 * Time: 23:16
 */

namespace Yosto\Arp\Cron;


class DailyCatalogUpdate
{
    /**
     * @var \Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor
     */
    protected $ruleProductProcessor;

    /**
     * @param \Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor $ruleProductProcessor
     */
    public function __construct(\Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor $ruleProductProcessor)
    {
        $this->ruleProductProcessor = $ruleProductProcessor;
    }

    /**
     * Daily update ARP rule by cron
     * Update include interval 3 days - current day - 1 days before + 1 days after
     * This method is called from cron process, cron is working in UTC time and
     * we should generate data for interval -1 day ... +1 day
     *
     * @return void
     */
    public function execute()
    {
        $this->ruleProductProcessor->markIndexerAsInvalid();
    }
}