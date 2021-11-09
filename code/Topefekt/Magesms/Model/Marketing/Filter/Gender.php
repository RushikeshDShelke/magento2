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
namespace Topefekt\Magesms\Model\Marketing\Filter; class Gender extends \Magento\Framework\DataObject implements FilterInterface { public $filter; public function __construct(array $ia61712c27ea241bd7a543dc2b02ea572274d0322 = []) { parent::__construct($ia61712c27ea241bd7a543dc2b02ea572274d0322); $this->filter = array( 'title' => __('Gender:'), 'firstItem' => __('All'), 'type' => 'select', 'name' => 'gender', 'color' => '#eeaaaa', ); } public function getValues() { $id92fd65e479a45fd28bc877dc5d15fc219af26db = []; $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $i287bcbe0c9dfb97b6c1bb92e5d892c0dea8b7ab0 = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create(\Magento\Eav\Model\Config::class); $ic7e041f1c0f99ab24f17177e95509393b8ba49be = $i287bcbe0c9dfb97b6c1bb92e5d892c0dea8b7ab0->getAttribute('customer', 'gender'); if ($ic7e041f1c0f99ab24f17177e95509393b8ba49be->getId()) { $id92fd65e479a45fd28bc877dc5d15fc219af26db = $ic7e041f1c0f99ab24f17177e95509393b8ba49be->getSource()->getAllOptions(false); foreach($id92fd65e479a45fd28bc877dc5d15fc219af26db as $i670253c23c6fcba76bc4256a88fdd8fbc1041039=>$i287bcbe0c9dfb97b6c1bb92e5d892c0dea8b7ab0) $id92fd65e479a45fd28bc877dc5d15fc219af26db[$i670253c23c6fcba76bc4256a88fdd8fbc1041039]['label'] = __($id92fd65e479a45fd28bc877dc5d15fc219af26db[$i670253c23c6fcba76bc4256a88fdd8fbc1041039]['label']); $id92fd65e479a45fd28bc877dc5d15fc219af26db = array_merge([['value' => '', 'label' => $this->filter['firstItem']]], $id92fd65e479a45fd28bc877dc5d15fc219af26db); } return $id92fd65e479a45fd28bc877dc5d15fc219af26db; } public function getFilter(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9, $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2) { $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e = []; foreach($i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 as $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { if ($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a instanceof $this) $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e[] = [$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValue()]; } if (count($i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e)) $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('gender', $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e); return $iff7e46827cbb6547116c592bf800f4687428abf9; } } 