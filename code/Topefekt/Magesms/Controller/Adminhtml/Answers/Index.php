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
namespace Topefekt\Magesms\Controller\Adminhtml\Answers; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $i84799dbe20e45b01ea358eb456ac86065d7c7b0c = $this->_resultPageFactory->create(); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->setActiveMenu('Topefekt_Magesms::magesms_answers'); $this->_addBreadcrumb(__('SMS Answers'), __('SMS Answers')); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->getConfig()->getTitle()->prepend(__('SMS Answers')); return $i84799dbe20e45b01ea358eb456ac86065d7c7b0c; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_answers'); } } 