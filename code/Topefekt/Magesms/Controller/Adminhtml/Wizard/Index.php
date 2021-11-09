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
 namespace Topefekt\Magesms\Controller\Adminhtml\Wizard; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Wizard { public function execute() { $i195899c9895b81b9bc75dba762c949638a6f36dd = $this->_country->create()->getCollection()->setOrder('name', 'ASC'); $this->getCoreRegistry()->register('countries', $i195899c9895b81b9bc75dba762c949638a6f36dd); $if64be516e155def9365330f8804d32d4959d58a2 = $this->getRoutes()->loadData('customer'); $this->getCoreRegistry()->register('routes_customer', $if64be516e155def9365330f8804d32d4959d58a2); $i4bbc012502242e693d490cecff87f891d3537a26 = $this->getRoutes()->loadData('admin'); $this->getCoreRegistry()->register('routes_admin', $i4bbc012502242e693d490cecff87f891d3537a26); $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('SMS Settings')); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('SMS Settings'), __('SMS Settings')); return $this; } } 