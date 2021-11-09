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
namespace Topefekt\Magesms\Observer; use Magento\Framework\Event\ObserverInterface; use Magento\Framework\Event\Observer as EventObserver; use Magento\Framework\Registry; class UpdateOrderStatusObserver implements ObserverInterface { protected $_hooks; protected $_registry; public function __construct( \Topefekt\Magesms\Model\Hooks $if739aceffec69fa2733946a3d319defaa354082d, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b ) { $this->_hooks = $if739aceffec69fa2733946a3d319defaa354082d; $this->_registry = $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b; } public function execute(EventObserver $i417760717250c854293598d2ff07a66629a1946d) { if ($this->_registry->registry('magesms_edit_order')) return $this; if ($i417760717250c854293598d2ff07a66629a1946d->getOrder()->getOrigData('status') != $i417760717250c854293598d2ff07a66629a1946d->getOrder()->getData('status')) { $this->_hooks->send('updateOrderStatus', $i417760717250c854293598d2ff07a66629a1946d->getOrder()); } } } 