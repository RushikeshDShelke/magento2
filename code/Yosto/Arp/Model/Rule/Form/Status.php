<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Form;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package Yosto\Arp\Model\Rule\Form
 */
class Status implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Active')],
            ['value' => 0, 'label' => __('Inactive')]
        ];
    }
}