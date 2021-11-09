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
namespace Topefekt\Magesms\Controller\Adminhtml\Profile; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $i84799dbe20e45b01ea358eb456ac86065d7c7b0c = $this->_resultPageFactory->create(); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->setActiveMenu('Topefekt_Magesms::magesms_profile'); $this->_addBreadcrumb(__('Edit user account'), __('Edit user account')); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->getConfig()->getTitle()->prepend(__('Edit user account')); if ($this->getRequest()->getParam('analyze') == $this->_mageHelper->getModuleVersion()) { $i8ee45e0018a32fb1a855b82624506e35789cc4d2 = $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->getLayout()->getBlock('magesms.profile.index'); $id82aaf2f437652c4b6efbd55703199f614e8e516 = '<!-- magesmsAnalyze: ' . $this->getUrl('*/*/', ['analyze' => $this->_mageHelper->getModuleVersion()]) . ' -->'; $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setMagesmsAnalyze($id82aaf2f437652c4b6efbd55703199f614e8e516); return $this->_api->analyze(); } return $i84799dbe20e45b01ea358eb456ac86065d7c7b0c; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_profile'); } } 