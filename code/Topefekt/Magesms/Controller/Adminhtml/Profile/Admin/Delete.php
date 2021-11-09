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
 namespace Topefekt\Magesms\Controller\Adminhtml\Profile\Admin; class Delete extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538 = (int)$this->getRequest()->getParam('id'); if ($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538 > 0) { if ($this->profile->admins->load($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538)) { $this->profile->admins->delete(); $this->getMessageManager()->addSuccessMessage(__('Admin was deleted.')); $this->_redirect('*/*/'); return; } } $this->getMessageManager()->addErrorMessage(__('Unable to find a Admin to delete.')); $this->_redirect('*/*/'); } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_profile'); } } 