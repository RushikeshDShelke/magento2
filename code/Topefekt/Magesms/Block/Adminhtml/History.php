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
 namespace Topefekt\Magesms\Block\Adminhtml; class History extends Marketing { protected function _prepareLayout() { $this->setCollection($this->getCoreRegistry()->registry('history')); $this->setFrom($this->getCoreRegistry()->registry('history_from')); $this->setTo($this->getCoreRegistry()->registry('history_to')); return parent::_prepareLayout(); } public function moreText($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa, $i4616676bff4c07942c8542e6b4e0ccf29d473424, $i41874a76da96da0584b16b9f04de6e3f06863c83) { if (strlen(utf8_decode($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa)) > $i41874a76da96da0584b16b9f04de6e3f06863c83) { $i838a72d011cf88c91dfc0040ea07c7fa8e44c6ae = mb_strpos($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa, ' ', $i4616676bff4c07942c8542e6b4e0ccf29d473424, 'UTF-8'); if ($i838a72d011cf88c91dfc0040ea07c7fa8e44c6ae > $i41874a76da96da0584b16b9f04de6e3f06863c83 || $i838a72d011cf88c91dfc0040ea07c7fa8e44c6ae == 0) $i838a72d011cf88c91dfc0040ea07c7fa8e44c6ae = $i41874a76da96da0584b16b9f04de6e3f06863c83; return '<span style="cursor:help;text-decoration:underline;" title="'.$i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa.'">'.mb_substr($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa, 0, $i838a72d011cf88c91dfc0040ea07c7fa8e44c6ae, 'UTF-8').'...</span>'; } else { return $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538fc9fbe8edf868c14fc4a3f15c7f40aabfa080aa; } } public function getCollection() { return $this->getData('collection'); } public function getSms() { return $this->_sms; } public function loadCustomer($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $i21e55df616c305955791876c1eb4da83448beba2 = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create(\Magento\Customer\Model\Customer::class); return $i21e55df616c305955791876c1eb4da83448beba2->load($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538); } public function loadAdmins($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $i21e55df616c305955791876c1eb4da83448beba2 = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create(\Topefekt\Magesms\Model\Admins::class); return $i21e55df616c305955791876c1eb4da83448beba2->load($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538); } } 