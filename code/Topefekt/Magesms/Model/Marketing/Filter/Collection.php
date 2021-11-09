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
 namespace Topefekt\Magesms\Model\Marketing\Filter; use Magento\Framework\DataObject; class Collection { private $ve713b4c10ff4c8425970eab3a4d765b3fe6fed6c; private $v148194b5b9cc653ce2e35e9709e441dc6fd4123a; private $v6d300b8ca8a5c97d244c2cd69be606018bc74d41; protected $cache; public function __construct(\Magento\Framework\Data\CollectionFactory $ibe5aea4950485d23eddda58cf80268b2bf918858, \Magento\Framework\App\CacheInterface $i8a92bcf60182619da740bda79c9a35b88694c213) { $this->cache = $i8a92bcf60182619da740bda79c9a35b88694c213; $this->v6d300b8ca8a5c97d244c2cd69be606018bc74d41 = $ibe5aea4950485d23eddda58cf80268b2bf918858; $ie713b4c10ff4c8425970eab3a4d765b3fe6fed6c = $ibe5aea4950485d23eddda58cf80268b2bf918858->create(); $this->ve713b4c10ff4c8425970eab3a4d765b3fe6fed6c = $ie713b4c10ff4c8425970eab3a4d765b3fe6fed6c; $i148194b5b9cc653ce2e35e9709e441dc6fd4123a = unserialize($i8a92bcf60182619da740bda79c9a35b88694c213->load('magesms_marketing_filter')); $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a = $i148194b5b9cc653ce2e35e9709e441dc6fd4123a; if (empty($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a) || !($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a instanceof DataObject)) { $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a = new DataObject(); $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->setData([ 'filters' => $this->v6d300b8ca8a5c97d244c2cd69be606018bc74d41->create(), 'customers' => new DataObject() ]); } } public function setCollection(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9) { if (($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538bc1a1bf6d5c2813b31ab86ea82f7ca5e65de27a = $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getCustomers()->getIds())) $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('entity_id', ['nin' => $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538bc1a1bf6d5c2813b31ab86ea82f7ca5e65de27a]); } public function addFilter($i2bd9743336318d0e14be0600c9129730279505dd) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create($i2bd9743336318d0e14be0600c9129730279505dd); if ($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) $this->ve713b4c10ff4c8425970eab3a4d765b3fe6fed6c->addItem($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a); else { } return $this; } public function addFilters(array $ie7d1f3c0ab09749c63a4d4213221b59ce80ea45c) { foreach($ie7d1f3c0ab09749c63a4d4213221b59ce80ea45c as $i2bd9743336318d0e14be0600c9129730279505dd) $this->addFilter($i2bd9743336318d0e14be0600c9129730279505dd); } public function getFilters() { $i5528ed14b056e3debe4695094269de3a98f76fe7 = ['' => '- '.__('Please Select').' -']; foreach($this->ve713b4c10ff4c8425970eab3a4d765b3fe6fed6c as $i670253c23c6fcba76bc4256a88fdd8fbc1041039=>$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { $i5528ed14b056e3debe4695094269de3a98f76fe7[$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['name']] = str_replace(':', '', $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['title']); } return $i5528ed14b056e3debe4695094269de3a98f76fe7; } public function setFilters(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9) { foreach($this->ve713b4c10ff4c8425970eab3a4d765b3fe6fed6c as $i670253c23c6fcba76bc4256a88fdd8fbc1041039=>$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getFilter($iff7e46827cbb6547116c592bf800f4687428abf9, $this->getCache()->getFilters()); } } public function getCache() { return isset($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a) ? $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a : null; } public function getAppliedFilters() { if (!empty($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a) && $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a instanceof DataObject) { return $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getFilters(); } } public function addApplyFilter($i2bd9743336318d0e14be0600c9129730279505dd, $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89) { if ($i2bd9743336318d0e14be0600c9129730279505dd) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create('Topefekt\\Magesms\\Model\\Marketing\\Filter\\'.ucfirst($i2bd9743336318d0e14be0600c9129730279505dd)); $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->setValue($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89); $i092fed12249a415fe47769fa9b0bb17968e798c0 = $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValues(); if (!empty($i092fed12249a415fe47769fa9b0bb17968e798c0[0]) && is_array($i092fed12249a415fe47769fa9b0bb17968e798c0[0])) { foreach($i092fed12249a415fe47769fa9b0bb17968e798c0 as $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa) { if ($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa['value'] == $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89) { $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->setLabel($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa['label']); break; } } } elseif (is_array($i092fed12249a415fe47769fa9b0bb17968e798c0) && array_key_exists($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89, $i092fed12249a415fe47769fa9b0bb17968e798c0)) { $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->setLabel($i092fed12249a415fe47769fa9b0bb17968e798c0[$if2eee0665f163a28f4adcfe84e3fc666bf1bcd89]); } $ia8418ed18227005524e0f3a24e89ce5b21e9b483 = false; foreach ($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getFilters() as $i705fa7c9639d497e1179d7d5691c212668a8c9c8) { if ($i705fa7c9639d497e1179d7d5691c212668a8c9c8 === $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { $ia8418ed18227005524e0f3a24e89ce5b21e9b483 = true; break; } } if (!$ia8418ed18227005524e0f3a24e89ce5b21e9b483) { $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getFilters()->addItem($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a); $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } } else { } } public function removeFilter($i670253c23c6fcba76bc4256a88fdd8fbc1041039) { $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getFilters()->removeItemByKey($i670253c23c6fcba76bc4256a88fdd8fbc1041039); $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } public function addRemoveCustomer($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538) { $iea1c44f6137731e1b13c494f784074e6a133577a = $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getCustomers()->getIds(); if (!is_array($iea1c44f6137731e1b13c494f784074e6a133577a)) $iea1c44f6137731e1b13c494f784074e6a133577a = []; if (in_array($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538, $iea1c44f6137731e1b13c494f784074e6a133577a)) $iea1c44f6137731e1b13c494f784074e6a133577a = array_diff($iea1c44f6137731e1b13c494f784074e6a133577a, [$i7d411c0cc32cdb65ec82b9e8d79aa996946f5538]); else $iea1c44f6137731e1b13c494f784074e6a133577a = array_merge($iea1c44f6137731e1b13c494f784074e6a133577a, [$i7d411c0cc32cdb65ec82b9e8d79aa996946f5538]); $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getCustomers()->setIds($iea1c44f6137731e1b13c494f784074e6a133577a); $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } public function resetFilter() { $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a = new DataObject(); $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->setData([ 'filters' => $this->v6d300b8ca8a5c97d244c2cd69be606018bc74d41->create(), 'customers' => new DataObject() ]); $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } public function toSerialize() { $ia61712c27ea241bd7a543dc2b02ea572274d0322 = ['filters' => [], 'customers' => []]; foreach($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getFilters() as $i705fa7c9639d497e1179d7d5691c212668a8c9c8) { $ia61712c27ea241bd7a543dc2b02ea572274d0322['filters'][] = ['name' => $i705fa7c9639d497e1179d7d5691c212668a8c9c8->filter['name'], 'value' => $i705fa7c9639d497e1179d7d5691c212668a8c9c8->getValue()]; } $ia61712c27ea241bd7a543dc2b02ea572274d0322['customers'] = $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getCustomers()->getIds(); return serialize($ia61712c27ea241bd7a543dc2b02ea572274d0322); } public function fromSerialize($ia61712c27ea241bd7a543dc2b02ea572274d0322) { $ia61712c27ea241bd7a543dc2b02ea572274d0322 = unserialize($ia61712c27ea241bd7a543dc2b02ea572274d0322, null); $this->resetFilter(); if (!empty($ia61712c27ea241bd7a543dc2b02ea572274d0322['filters'])) { foreach($ia61712c27ea241bd7a543dc2b02ea572274d0322['filters'] as $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { $this->addApplyFilter($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a['name'], $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a['value']); } } if (!empty($ia61712c27ea241bd7a543dc2b02ea572274d0322['customers']) && is_array($ia61712c27ea241bd7a543dc2b02ea572274d0322['customers'])) $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a->getCustomers()->setIds($ia61712c27ea241bd7a543dc2b02ea572274d0322['customers']); $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } private function f403d2b0a9c44d21482a17bcb162aa54ccb79be64() { if (!empty($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a)) $this->cache->save(serialize($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a), 'magesms_marketing_filter'); } public function __destruct() { $this->f403d2b0a9c44d21482a17bcb162aa54ccb79be64(); } } 