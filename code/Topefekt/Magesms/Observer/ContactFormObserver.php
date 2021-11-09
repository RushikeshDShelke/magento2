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
namespace Topefekt\Magesms\Observer; use Magento\Framework\Event\ObserverInterface; use Magento\Framework\Event\Observer as EventObserver; class ContactFormObserver implements ObserverInterface { protected $_hooks; protected $_helper; public function __construct( \Topefekt\Magesms\Helper\Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, \Topefekt\Magesms\Model\Hooks $if739aceffec69fa2733946a3d319defaa354082d ) { $this->_hooks = $if739aceffec69fa2733946a3d319defaa354082d; $this->_helper = $i0d09b2a4f282150bf47b02f9f3d82586fe313844; } public function execute(EventObserver $i417760717250c854293598d2ff07a66629a1946d) { if (!$this->_helper->isActive()) return $this; $this->_hooks->send('contactForm', $i417760717250c854293598d2ff07a66629a1946d, true); } } 