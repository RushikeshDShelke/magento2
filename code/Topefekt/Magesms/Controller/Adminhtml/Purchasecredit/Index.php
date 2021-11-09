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
namespace Topefekt\Magesms\Controller\Adminhtml\Purchasecredit; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $i84799dbe20e45b01ea358eb456ac86065d7c7b0c = $this->_resultPageFactory->create(); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->setActiveMenu('Topefekt_Magesms::magesms_purchasecredit'); $this->_addBreadcrumb(__('Purchase Credit'), __('Purchase Credit')); $i84799dbe20e45b01ea358eb456ac86065d7c7b0c->getConfig()->getTitle()->prepend(__('Purchase Credit')); $i8ee45e0018a32fb1a855b82624506e35789cc4d2 = $this->_view->getLayout()->getBlock('magesms.purchasecredit.index'); foreach ($this->profile->country as $i705fa7c9639d497e1179d7d5691c212668a8c9c8) { if ($i705fa7c9639d497e1179d7d5691c212668a8c9c8->getName() == $this->profile->user->getCountry()) { $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setVat($i705fa7c9639d497e1179d7d5691c212668a8c9c8->getVat()); break; } } return $i84799dbe20e45b01ea358eb456ac86065d7c7b0c; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_purchasecredit'); } } 