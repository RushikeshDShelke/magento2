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
 namespace Topefekt\Magesms\Controller\Adminhtml\Adminsms; use Magento\Framework\App\RequestInterface; use Magento\Framework\Data\Collection; use Magento\Framework\DataObject; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Adminsms { private $v2b483c223d472d1fb22c9823dcc35f84765b2c06; public function dispatch(RequestInterface $ib2c014c384e400e98e6977efa41c20d14e2c7dea) { $i2b483c223d472d1fb22c9823dcc35f84765b2c06 = $this->getCollectionFactory()->create(); $this->v2b483c223d472d1fb22c9823dcc35f84765b2c06 = $i2b483c223d472d1fb22c9823dcc35f84765b2c06; $this->v2b483c223d472d1fb22c9823dcc35f84765b2c06->addItem(new DataObject( [ 'group' => 'order_status', 'name' => 'Order status', 'icon' => 'images/AdminOrders.gif' ] ))->addItem(new DataObject( [ 'group' => 'order', 'name' => 'Order', 'icon' => 'images/AdminOrders.gif' ] ))->addItem(new DataObject( [ 'group' => 'account', 'name' => 'Account', 'icon' => 'images/AdminCustomers.gif' ] ))->addItem(new DataObject( [ 'group' => 'product', 'name' => 'Product', 'icon' => 'images/AdminCatalog.gif' ] ))->addItem(new DataObject( [ 'group' => 'contactform', 'name' => 'Contact form', 'icon' => 'images/AdminCatalog.gif' ] )); return parent::dispatch($ib2c014c384e400e98e6977efa41c20d14e2c7dea); } public function execute() { $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd = $this->getUnicodeFactory()->create()->getCollection() ->addFilter('type', 'admin')->getFirstItem(); $this->getCoreRegistry()->register('hooks_unicode', $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd); foreach ($this->v2b483c223d472d1fb22c9823dcc35f84765b2c06 as $group) { $group->setHooks($this->getHooks()->getHooks($group->getGroup(), 'admins')); } $this->getCoreRegistry()->register('hooks_groups', $this->v2b483c223d472d1fb22c9823dcc35f84765b2c06); $i94ad4ca0f944952a9b3b77a6a8f2a5001485dc7c = $this->getGroupFactory()->create()->getCollection()->setLoadDefault(false); $this->getCoreRegistry()->register('store_group', $i94ad4ca0f944952a9b3b77a6a8f2a5001485dc7c); $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Admin SMS')); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('Admin SMS'), __('Admin SMS')); return $this; } } 