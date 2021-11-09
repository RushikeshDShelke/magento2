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
 namespace Topefekt\Magesms\Controller\Adminhtml; use Magento\Backend\App\Action\Context; use Magento\Framework\Registry; use Magento\Framework\View\Result\PageFactory; use Topefekt\Magesms\Helper\Data; use Topefekt\Magesms\Model\Api; use Topefekt\Magesms\Model\CountryFactory; use Topefekt\Magesms\Model\Ownnumbersender; use Topefekt\Magesms\Model\Routes; use Topefekt\Magesms\Model\Smsprofile; use Topefekt\Magesms\Model\Textsender; abstract class Wizard extends \Topefekt\Magesms\Controller\Adminhtml\Action { protected $_country; protected $_routes; protected $_ownnumbersender; protected $_textsender; public function __construct(Context $i31cc913adc2717e2346d503153c97449098831aa, PageFactory $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, Smsprofile $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, Api $i451f679eaafeecb81387b150019f0d9e0fa83d16, Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b, CountryFactory $i037b855bc01175f2c77d5c3e19eda9a0003feff4, Routes $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec, Ownnumbersender $i1ad1e2c93d17b0cc1f975eb7f24bf76446264c6f, Textsender $i340682ca0ed5a64e8ea449191da847abaf0aec6f) { parent::__construct($i31cc913adc2717e2346d503153c97449098831aa, $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, $i451f679eaafeecb81387b150019f0d9e0fa83d16, $i0d09b2a4f282150bf47b02f9f3d82586fe313844, $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b); $this->_country = $i037b855bc01175f2c77d5c3e19eda9a0003feff4; $this->_routes = $ie8b7b1b62dc29a284d794c9f11a8ee2ea7472eec; $this->_ownnumbersender = $i1ad1e2c93d17b0cc1f975eb7f24bf76446264c6f; $this->_textsender = $i340682ca0ed5a64e8ea449191da847abaf0aec6f; } public function getOwnnumbersender() { return $this->_ownnumbersender; } public function getTextsender() { return $this->_textsender; } public function getCountryFactory() { return $this->_country; } public function getRoutes() { return $this->_routes; } public function _initAction() { parent::_initAction(); $this->_setActiveMenu('Topefekt_Magesms::magesms_wizard'); return $this; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_wizard'); } } 