<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Form;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class BlockPosition
 * @package Yosto\Arp\Model\Rule\Form
 */
class BlockPosition implements OptionSourceInterface
{
    const INSTEAD_OF_NATIVE_RELATED_BLOCK = 0;
    const INSTEAD_OF_NATIVE_UP_SELL_BLOCK = 1;
    const INSTED_OF_NATIVE_CROSS_SELL_BLOCK = 2;

    public function toOptionArray()
    {
        return [
            ['label' => __('Instead of Native Related Block'), 'value' => self::INSTEAD_OF_NATIVE_RELATED_BLOCK],
            ['label' => __('Instead of Native Upsell Block'), 'value' => self::INSTEAD_OF_NATIVE_UP_SELL_BLOCK],
            ['label' => __('Instead of Native Cross-sell Block'), 'value' => self::INSTED_OF_NATIVE_CROSS_SELL_BLOCK]
        ];
    }

}