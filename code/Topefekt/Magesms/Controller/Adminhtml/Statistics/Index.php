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
namespace Topefekt\Magesms\Controller\Adminhtml\Statistics; class Index extends \Topefekt\Magesms\Controller\Adminhtml\History { public function execute() { $iff7e46827cbb6547116c592bf800f4687428abf9 = $this->getHistoryFactory()->create()->getCollection(); $i453d72d1a00368b67f4cf9d613ee7f09bb54ce66 = $this->getRequest()->getParam('datefrom'); $i3d324ac33201e0d541c708e75c85dee82d201754 = $this->getRequest()->getParam('dateto'); $i3ad1587c5e634f88620f6fbe7aec68e06b35aedc = $i453d72d1a00368b67f4cf9d613ee7f09bb54ce66 ? date('Y-m-d', strtotime($i453d72d1a00368b67f4cf9d613ee7f09bb54ce66)) : date('Y-m-d'); $i59c054dfefe7a5ed41deddfad6b89cf79a03a915 = $i453d72d1a00368b67f4cf9d613ee7f09bb54ce66 ? date('Y-m-d', strtotime($i3d324ac33201e0d541c708e75c85dee82d201754)) : date('Y-m-d'); $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('date', array('from' => $i3ad1587c5e634f88620f6fbe7aec68e06b35aedc.' 00:00:00')) ->addFieldToFilter('date', array('to' => $i59c054dfefe7a5ed41deddfad6b89cf79a03a915.' 23:59:59')); if (($i6dc291db3e1b662b3da435666456bf9c7b8f9206 = $this->getRequest()->getParam('status'))) { $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('status', $i6dc291db3e1b662b3da435666456bf9c7b8f9206); } $i83e615fa5ecf9291e01ccef41ed5ec1bce147664 = array(); if ($this->getRequest()->getParam('eshopsms', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 2; if ($this->getRequest()->getParam('eshopsms1', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 1; if ($this->getRequest()->getParam('bulksms', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 3; if ($this->getRequest()->getParam('bulksms2', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 4; if (count($i83e615fa5ecf9291e01ccef41ed5ec1bce147664)) { $iff7e46827cbb6547116c592bf800f4687428abf9->addFieldToFilter('type', array('nin' => $i83e615fa5ecf9291e01ccef41ed5ec1bce147664)); } $this->getCoreRegistry()->register('history', $iff7e46827cbb6547116c592bf800f4687428abf9); $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Statistics')); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('Statistics'), __('Statistics')); $this->_setActiveMenu('Topefekt_Magesms::magesms_statistics'); return $this; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_statistics'); } } 