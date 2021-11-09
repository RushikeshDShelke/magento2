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
 namespace Topefekt\Magesms\Model\System\Config; class Connector implements \Magento\Framework\Option\ArrayInterface { public function toOptionArray() { return [ [ 'value' => '', 'label' => __('Auto (SSL priority)'), ], [ 'value' => 'ssl', 'label' => __('fsockopen (SSL)'), ], [ 'value' => 'curl-ssl', 'label' => __('CURL (SSL)'), ], [ 'value' => 'no-ssl', 'label' => __('fsockopen (no-SSL)'), ], [ 'value' => 'curl', 'label' => __('CURL (no-SSL)'), ], ]; } } 