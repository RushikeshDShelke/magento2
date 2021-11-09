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
 namespace Topefekt\Magesms\Block\Adminhtml\Marketing; use Topefekt\Magesms\Block\Adminhtml\Marketing; class Customer extends Marketing { protected function _construct() { parent::_construct(); $this->setTemplate('marketing/customer.phtml'); } public function getClassName() { return strtolower((new \ReflectionClass($this))->getShortName()); } protected function _toHtml() { return '<div id="magesms-marketing-'.$this->getClassName().'">'.parent::_toHtml().'</div>'; } public function getCollection() { return $this->getCoreRegistry()->registry('magesms_marketing_collection'); } public function getTitle() { return __('Customers found: '); } public function getDeleteCustomer() { return false; } public function displayByAlphabet() { $i39d2c3f69cb73b5684f101b504090c13c5174bc4 = []; foreach($this->getCollection() as $i21e55df616c305955791876c1eb4da83448beba2) { $i47b2a41e4081b6f8d8381f411087dcd7042bfb53 = mb_strtoupper(mb_substr(trim($i21e55df616c305955791876c1eb4da83448beba2->getLastname()), 0, 1, 'utf-8')); if (empty($i39d2c3f69cb73b5684f101b504090c13c5174bc4[$i47b2a41e4081b6f8d8381f411087dcd7042bfb53])) $i39d2c3f69cb73b5684f101b504090c13c5174bc4[$i47b2a41e4081b6f8d8381f411087dcd7042bfb53] = $this->_collectionFactory->create(); $i39d2c3f69cb73b5684f101b504090c13c5174bc4[$i47b2a41e4081b6f8d8381f411087dcd7042bfb53]->addItem($i21e55df616c305955791876c1eb4da83448beba2); } ksort($i39d2c3f69cb73b5684f101b504090c13c5174bc4); return $i39d2c3f69cb73b5684f101b504090c13c5174bc4; } } 