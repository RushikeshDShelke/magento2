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
 namespace Topefekt\Magesms\Block\Adminhtml\Marketing; class CustomerDeleted extends Customer { public function getCollection() { $iff7e46827cbb6547116c592bf800f4687428abf9 = $this->getMageHelper()->getCustomerCollection(); $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('entity_id', ['in' => $this->getFilterCollection()->getCache()->getCustomers()->getIds()]); return $iff7e46827cbb6547116c592bf800f4687428abf9; } public function getTitle() { return __('Removed Customers: '); } public function getDeleteCustomer() { return true; } } 