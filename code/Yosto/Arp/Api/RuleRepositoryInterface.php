<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RuleRepositoryInterface
 * @package Yosto\Arp\Api
 */
interface RuleRepositoryInterface
{


    /**
     * Save rule
     * @param \Yosto\Arp\Api\Data\RuleInterface $rule
     * @return \Yosto\Arp\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(\Yosto\Arp\Api\Data\RuleInterface $rule);

    /**
     * Retrieve rule
     * @param string $ruleId
     * @return \Yosto\Arp\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($ruleId);

    /**
     * Retrieve rule matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Yosto\Arp\Api\Data\RuleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete rule
     * @param \Yosto\Arp\Api\Data\RuleInterface $rule
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(\Yosto\Arp\Api\Data\RuleInterface $rule);

    /**
     * Delete rule by ID
     * @param string $ruleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($ruleId);
}
