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
namespace Topefekt\Magesms\Block\Adminhtml; use Magento\Backend\Block\Template\Context; use Topefekt\Magesms\Helper\Data; use Topefekt\Magesms\Model\Sms; use Topefekt\Magesms\Model\Smsprofile; use Magento\Framework\Registry; class Template extends \Magento\Backend\Block\Template { public $profile; protected $_sms; protected $_coreRegistry; protected $_helper; public function __construct(Context $i31cc913adc2717e2346d503153c97449098831aa, Smsprofile $i3a81d7d700dc6d1b4279ed33db8d01cd2cae8ed9, Sms $i2012325f8714e1168a6c4fd06b9fa8eee23fcc7f, Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b, array $ia61712c27ea241bd7a543dc2b02ea572274d0322 = []) { parent::__construct($i31cc913adc2717e2346d503153c97449098831aa, $ia61712c27ea241bd7a543dc2b02ea572274d0322); $this->profile = $i3a81d7d700dc6d1b4279ed33db8d01cd2cae8ed9; $this->_sms = $i2012325f8714e1168a6c4fd06b9fa8eee23fcc7f; $this->_coreRegistry = $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b; $this->_helper = $i0d09b2a4f282150bf47b02f9f3d82586fe313844; } public function getStoreManager() { return $this->_storeManager; } public function getMageHelper() { return $this->_helper; } public function getLocaleDate() { return $this->_localeDate; } public function getCoreRegistry() { return $this->_coreRegistry; } } 