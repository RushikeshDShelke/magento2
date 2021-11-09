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
namespace Topefekt\Magesms\Observer; use Magento\Framework\Event\ObserverInterface; use Magento\Framework\Event\Observer as EventObserver; use Magento\Framework\Registry; class NewOrderObserver implements ObserverInterface { protected $_helper; protected $_profile; protected $_hooks; protected $_registry; protected $_optoutOrder; public function __construct( \Topefekt\Magesms\Helper\Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, \Topefekt\Magesms\Model\Hooks $if739aceffec69fa2733946a3d319defaa354082d, \Topefekt\Magesms\Model\Smsprofile $i3a81d7d700dc6d1b4279ed33db8d01cd2cae8ed9, \Topefekt\Magesms\Model\Optout\Order $i82da72a71a7a144dd822c68ae0549ee773619a57, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b ) { $this->_helper = $i0d09b2a4f282150bf47b02f9f3d82586fe313844; $this->_profile = $i3a81d7d700dc6d1b4279ed33db8d01cd2cae8ed9; $this->_hooks = $if739aceffec69fa2733946a3d319defaa354082d; $this->_registry = $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b; $this->_optoutOrder = $i82da72a71a7a144dd822c68ae0549ee773619a57; } public function execute(EventObserver $i417760717250c854293598d2ff07a66629a1946d) { if (!$this->_helper->isActive()) return $this; if ($i417760717250c854293598d2ff07a66629a1946d->getEvent()->getOrder()->getRelationParentId()) { $this->_registry->register('magesms_edit_order', true, true); return $this; } $i69a1201e93806d55c970dfb18feec53d221ba37b = $this->_helper->getOptoutProduct(); if ($i69a1201e93806d55c970dfb18feec53d221ba37b) { $if80f0cbea56595a4489db73147386c11bb406a7e = $i417760717250c854293598d2ff07a66629a1946d->getEvent()->getOrder(); $i705fa7c9639d497e1179d7d5691c212668a8c9c8 = $if80f0cbea56595a4489db73147386c11bb406a7e->getQuote()->getItemByProduct($i69a1201e93806d55c970dfb18feec53d221ba37b); if (!$i705fa7c9639d497e1179d7d5691c212668a8c9c8) { $ib8129b89cda7dae2cfe1b114353de8ba2385974e = $this->_optoutOrder; $ib8129b89cda7dae2cfe1b114353de8ba2385974e->setOrderId($if80f0cbea56595a4489db73147386c11bb406a7e->getId())->setDisabled(1); $ib8129b89cda7dae2cfe1b114353de8ba2385974e->save(); } } $this->_hooks->send('newOrder', $i417760717250c854293598d2ff07a66629a1946d->getOrder()); } } 