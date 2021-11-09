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
 namespace Topefekt\Magesms\Block\Adminhtml\Wizard; use Topefekt\Magesms\Model\Ownnumbersender; use Topefekt\Magesms\Model\Routes; use Topefekt\Magesms\Model\Textsender; class Sender extends \Topefekt\Magesms\Block\Adminhtml\Wizard { protected function _prepareLayout() { if ($this->getCoreRegistry()->registry('routes')) { $this->setRoutes($this->getCoreRegistry()->registry('routes')); $this->setOwnnumbersender($this->getCoreRegistry()->registry('ownnumbersender')); $this->setTextsender($this->getCoreRegistry()->registry('textsender')); } return parent::_prepareLayout(); } public function getRoutes() { return $this->getData('routes'); } public function getOwnnumbersender() { return $this->getData('ownnumbersender'); } public function getTextsender() { return $this->getData('textsender'); } } 