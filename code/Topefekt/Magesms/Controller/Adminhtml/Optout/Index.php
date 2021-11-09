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
namespace Topefekt\Magesms\Controller\Adminhtml\Optout; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Optout { public function execute() { $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('SMS opt-out - setting SMS opt-out option from the cart and SMS charging')); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('SMS opt-out'), __('SMS opt-out')); return $this; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_optout'); } } 