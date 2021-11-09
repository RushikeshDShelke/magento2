<?php
/**
 * Mage SMS - SMS notification & SMS marketing
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the BSD 3-Clause License
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/BSD-3-Clause
 *
 * @category    TOPefekt
 * @package     TOPefekt_Magesms
 * @copyright   Copyright (c) 2012-2017 TOPefekt s.r.o. (http://www.mage-sms.com)
 * @license     http://opensource.org/licenses/BSD-3-Clause
 */
 namespace Topefekt\Magesms\Model\System\Config; class Lang implements \Magento\Framework\Option\ArrayInterface { public function toOptionArray() { return [ [ 'value' => 'cz', 'label' => 'Czech', ], [ 'value' => 'de', 'label' => 'German', ], [ 'value' => 'el', 'label' => 'Greek', ], [ 'value' => 'en', 'label' => 'English', ], [ 'value' => 'es', 'label' => 'Spanish', ], [ 'value' => 'fr', 'label' => 'French', ], [ 'value' => 'it', 'label' => 'Italian', ], [ 'value' => 'pl', 'label' => 'Polish', ], [ 'value' => 'pt', 'label' => 'Portuguese', ], [ 'value' => 'ru', 'label' => 'Russian', ], [ 'value' => 'sk', 'label' => 'Slovak', ], [ 'value' => 'sr', 'label' => 'Serbian', ], [ 'value' => 'sv', 'label' => 'Swedish', ], [ 'value' => 'tr', 'label' => 'Turkish', ], ]; } } 