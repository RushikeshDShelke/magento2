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
 namespace Topefekt\Magesms\Controller\Adminhtml\Wizard; class AddCountry extends \Topefekt\Magesms\Controller\Adminhtml\Wizard { public function execute() { $i037b855bc01175f2c77d5c3e19eda9a0003feff4 = $this->getRequest()->getParam('country'); $i30f20aafde612a957f7f966cb5b85e35782bc88a = $this->getRequest()->getParam('type'); if ($i037b855bc01175f2c77d5c3e19eda9a0003feff4 && $i30f20aafde612a957f7f966cb5b85e35782bc88a) { $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec = $this->getRoutes()->getCollection() ->addFieldToFilter('area_text', $i037b855bc01175f2c77d5c3e19eda9a0003feff4)->addFieldToFilter('type', $i30f20aafde612a957f7f966cb5b85e35782bc88a); if ($ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->count()) { $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538 = $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->getFirstItem()->getId(); $this->_redirect('*/*/edit', ['country' => $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->getFirstItem()->getAreaText(), 'id' => $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538]); return; } $this->_redirect('*/*/edit', ['country' => $i037b855bc01175f2c77d5c3e19eda9a0003feff4, 'type' => $i30f20aafde612a957f7f966cb5b85e35782bc88a]); return; } $this->getMessageManager()->addErrorMessage(__('Unable to find a Route to load.')); $this->_redirect('*/*/'); } } 