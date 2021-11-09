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
 namespace Topefekt\Magesms\Controller\Adminhtml\Wizard\Sender; class Save extends \Topefekt\Magesms\Controller\Adminhtml\Wizard { public function execute() { if ($this->getSession()->hasRoutes()) { $this->_redirect('*/*/sender'); return; } else { $this->getMessageManager()->addSuccessMessage($this->getSession()->getRouteSuccess().__(' was saved.')); $this->getSession()->unsRouteSuccess(); } $this->_redirect('*/*/'); } } 