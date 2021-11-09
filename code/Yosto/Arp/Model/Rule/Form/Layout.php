<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Form;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Layout
 * @package Yosto\Arp\Model\Rule\Form
 */
class Layout implements OptionSourceInterface
{
    const SLIDER = 0;
    const GRID = 1;
    public function toOptionArray()
    {
       return [
           ['label' => __('Slider'), 'value' => self::SLIDER ],
           ['label' => __('Grid'), 'value' => self::GRID ]
       ];
    }

}