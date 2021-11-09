<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Rule;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class WhatConditions
 * @package Yosto\Arp\Block\Rule
 */
class WhatConditions implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {

        /**@var \Yosto\Arp\Model\Rule $rule */
        $rule = $element->getRule();

        if ($rule && $rule->getWhatConditions()) {
            return $rule->getWhatConditions()->asHtmlRecursive();
        }


        return '';
    }
}