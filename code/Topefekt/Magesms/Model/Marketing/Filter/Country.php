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
namespace Topefekt\Magesms\Model\Marketing\Filter; class Country extends \Magento\Framework\DataObject implements FilterInterface { public $filter; public function __construct(array $ia61712c27ea241bd7a543dc2b02ea572274d0322 = []) { parent::__construct($ia61712c27ea241bd7a543dc2b02ea572274d0322); $this->filter = [ 'title' => __('Country'), 'firstItem' => __('All countries'), 'type' => 'select', 'name' => 'country', 'color' => '#005784', ]; } public function getValues() { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $i037b855bc01175f2c77d5c3e19eda9a0003feff4 = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create(\Magento\Directory\Model\ResourceModel\Country\Collection::class); return array_merge( [['value' => '', 'label' => $this->filter['firstItem']]], $i037b855bc01175f2c77d5c3e19eda9a0003feff4->toOptionArray(false) ); } public function getFilter(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9, $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2) { $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e = []; foreach($i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 as $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { if ($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a instanceof $this) $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e[] = [$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValue()]; } if (count($i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e)) $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('billing_country_id', $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e); return $iff7e46827cbb6547116c592bf800f4687428abf9; } } 