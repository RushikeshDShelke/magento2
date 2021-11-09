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
namespace Topefekt\Magesms\Controller\Adminhtml\History; class Deleteall extends \Topefekt\Magesms\Controller\Adminhtml\History { public function execute() { $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd = $this->getHistoryFactory()->create(); $i13e7e92bf1e1fca680dff52183c53c3b088a9193 = $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd->getCollection()->getConnection(); $i7af9c0bf5c8f0878a0f7c5463d75397834eda9fa = $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd->getCollection()->getMainTable(); $i13e7e92bf1e1fca680dff52183c53c3b088a9193->truncateTable($i7af9c0bf5c8f0878a0f7c5463d75397834eda9fa); $this->messageManager->addSuccessMessage(__('SMS history was deleted.')); $this->_redirect('*/*/'); } } 