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
 namespace Topefekt\Magesms\Model\Marketing\Filter; class Birthday extends \Magento\Framework\DataObject implements FilterInterface { public $filter; public function __construct(array $ia61712c27ea241bd7a543dc2b02ea572274d0322 = []) { parent::__construct($ia61712c27ea241bd7a543dc2b02ea572274d0322); $this->filter = [ 'title' => __('Date of birth from: '), 'type' => 'date', 'name' => 'birthday', 'color' => '#907523', 'glue' => ' / '.__('to: '), ]; } public function getFilter(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9, $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2) { $i62074d2d0e606cbe67bd6b024f6c2eaac2029c2e = []; $ie2a167ef859b6a69d0dc6803ded0a2a49f59ce69 = []; foreach($i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 as $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { if ($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a instanceof $this) { $i3ca4aff6918962dee4a8054ca52f13ef3b6bab08 = $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValue(); if (!empty($i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[0])) $i62074d2d0e606cbe67bd6b024f6c2eaac2029c2e[] = ['from' => date('Y-m-d H:i:s', strtotime($i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[0]))]; if (!empty($i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[1])) $ie2a167ef859b6a69d0dc6803ded0a2a49f59ce69[] = ['to' => date('Y-m-d H:i:s', strtotime($i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[1]))]; } } if (count($i62074d2d0e606cbe67bd6b024f6c2eaac2029c2e)) $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('dob', $i62074d2d0e606cbe67bd6b024f6c2eaac2029c2e); if (count($ie2a167ef859b6a69d0dc6803ded0a2a49f59ce69)) $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('dob', $ie2a167ef859b6a69d0dc6803ded0a2a49f59ce69); return $iff7e46827cbb6547116c592bf800f4687428abf9; } } 