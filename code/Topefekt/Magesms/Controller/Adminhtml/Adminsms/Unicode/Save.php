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
 namespace Topefekt\Magesms\Controller\Adminhtml\Adminsms\Unicode; class Save extends \Topefekt\Magesms\Controller\Adminhtml\Adminsms { public function execute() { $i7137e40370cf1c5ccf937060891613788203e2d6 = 'default'; $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd = $this->getUnicodeFactory()->create()->getCollection(); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->addFieldToFilter('area', $i7137e40370cf1c5ccf937060891613788203e2d6) ->addFieldToFilter('type', 'admin'); if (!$ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->count()) { $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd = $this->getUnicodeFactory()->create(); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->setArea($i7137e40370cf1c5ccf937060891613788203e2d6); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->setType('admin'); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->setUnicode($this->getRequest()->getParam('unicode', 0)); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->save(); } else { $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->getFirstItem()->setUnicode($this->getRequest()->getParam('unicode', 0)); $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd->getFirstItem()->save(); } $this->messageManager->addSuccessMessage(__('Unicode was saved.')); $this->_redirect('*/*/'); } } 