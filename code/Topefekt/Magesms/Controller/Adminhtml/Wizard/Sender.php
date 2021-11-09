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
 namespace Topefekt\Magesms\Controller\Adminhtml\Wizard; class Sender extends \Topefekt\Magesms\Controller\Adminhtml\Wizard { public function execute() { if (!$this->getSession()->hasRoutes()) { $this->_redirect('*/*/'); return; } $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec = $this->getRoutes(); $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->setData($this->getSession()->getRoutes()); $this->getCoreRegistry()->register('routes', $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec); $this->getCoreRegistry()->register('ownnumbersender', $this->getOwnnumbersender()); $this->getCoreRegistry()->register('textsender', $this->getTextsender()); if ($ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->getSendertype() == \Topefekt\Magesms\Model\Routes::SENDER_TEXT) $ib605a096f442fa4dba073a8f5d37efb1add4650f = __('SMS Settings - Select Text sender ID for '); elseif ($ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->getSendertype() == \Topefekt\Magesms\Model\Routes::SENDER_OWN) $ib605a096f442fa4dba073a8f5d37efb1add4650f = __('SMS Settings - Select Own number sender ID for '); else $ib605a096f442fa4dba073a8f5d37efb1add4650f = ''; $ib605a096f442fa4dba073a8f5d37efb1add4650f .= $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec->getAreaText(); $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__($ib605a096f442fa4dba073a8f5d37efb1add4650f)); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('SMS Settings'), __('SMS Settings')); return $this; } } 