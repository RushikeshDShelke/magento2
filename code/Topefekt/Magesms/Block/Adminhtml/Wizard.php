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
 namespace Topefekt\Magesms\Block\Adminhtml; class Wizard extends Marketing { public $list_type; protected function _prepareLayout() { if ($this->list_type) { if ($this->getCoreRegistry()->registry('route')) { $ice10b700e3771fcda63608142bce93b608228583 = $this->getCoreRegistry()->registry('route'); $this->setRoutes([$ice10b700e3771fcda63608142bce93b608228583]); } elseif ($this->getCoreRegistry()->registry('routes_'.$this->list_type)) { $this->setRoutes($this->getCoreRegistry()->registry('routes_'.$this->list_type)); } } elseif ($this->getCoreRegistry()->registry('route')) { $ice10b700e3771fcda63608142bce93b608228583 = $this->getCoreRegistry()->registry('route'); $this->setRoutes([$ice10b700e3771fcda63608142bce93b608228583]); } if ($this->getCoreRegistry()->registry('countries')) $this->setCountries($this->getCoreRegistry()->registry('countries')); return parent::_prepareLayout(); } public function getCountryName() { return $this->getCoreRegistry()->registry('country_name'); } public function getCountryArea() { return $this->getCoreRegistry()->registry('country_area'); } } 