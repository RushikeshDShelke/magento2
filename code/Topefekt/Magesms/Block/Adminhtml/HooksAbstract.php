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
 namespace Topefekt\Magesms\Block\Adminhtml; abstract class HooksAbstract extends Marketing { protected function _prepareLayout() { $groups = $this->getCoreRegistry()->registry('hooks_groups'); $this->setGroups($groups); $this->setStores($this->getCoreRegistry()->registry('store_group')); return parent::_prepareLayout(); } public function getUnicode() { return $this->getCoreRegistry()->registry('hooks_unicode'); } public function getGroups() { return $this->getData('groups'); } } 