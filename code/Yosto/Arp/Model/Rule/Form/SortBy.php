<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Form;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class SortBy
 * @package Yosto\Arp\Model\Rule\Form
 */
class SortBy implements OptionSourceInterface
{
    const MOST_VIEWED = 0;
    const BEST_SELLER = 1;
    const BEST_RATED = 2;
    public function toOptionArray()
    {
        return [
            ['label' => __("Most Viewed"), 'value' => self::MOST_VIEWED],
            ['label' => __("Best Seller"), 'value' => self::BEST_SELLER],
            ['label' => __("Best Rated"), 'value' => self::BEST_RATED],
        ];
    }

}