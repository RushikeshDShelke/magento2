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
 namespace Topefekt\Magesms\Controller\Adminhtml\Wizard; class Delete extends \Topefekt\Magesms\Controller\Adminhtml\Wizard { public function execute() { if ($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538 = $this->getRequest()->getParam('id')) { $ice10b700e3771fcda63608142bce93b608228583 = $this->getRoutes()->load($i7d411c0cc32cdb65ec82b9e8d79aa996946f5538); $ice10b700e3771fcda63608142bce93b608228583->delete(); $this->getMessageManager()->addSuccessMessage($ice10b700e3771fcda63608142bce93b608228583->getAreaText().__(' was deleted.')); $this->_redirect('*/*/'); return; } $this->getMessageManager()->addErrorMessage(__('Unable to find a Route to delete.')); $this->_redirect('*/*/'); } } 