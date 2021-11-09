<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Api\Data;
/**
 * Interface RuleSearchResultsInterface
 * @package Yosto\Arp\Api\Data
 */
interface RuleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get rule list.
     * @return \Yosto\Arp\Api\Data\RuleInterface[]
     */
    
    public function getItems();

    /**
     * Set is_active list.
     * @param \Yosto\Arp\Api\Data\RuleInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
