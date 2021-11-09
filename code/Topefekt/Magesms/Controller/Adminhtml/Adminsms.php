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
namespace Topefekt\Magesms\Controller\Adminhtml; use Magento\Backend\App\Action\Context; use Magento\Framework\Data\CollectionFactory; use Magento\Framework\View\Result\PageFactory; use Magento\Store\Model\GroupFactory; use Topefekt\Magesms\Helper\Data; use Topefekt\Magesms\Model\Api; use Topefekt\Magesms\Model\Hooks; use Topefekt\Magesms\Model\Hooks\UnicodeFactory; use Topefekt\Magesms\Model\Smsprofile; use Magento\Framework\Registry; abstract class Adminsms extends \Topefekt\Magesms\Controller\Adminhtml\Action { protected $_unicodeFactory; protected $collectionFactory; protected $_hooks; protected $_groupFactory; public function __construct(Context $i31cc913adc2717e2346d503153c97449098831aa, PageFactory $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, Smsprofile $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, Api $i451f679eaafeecb81387b150019f0d9e0fa83d16, Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b, UnicodeFactory $i57fd63e5200bfe7bc291e35785f410285397863d, CollectionFactory $ibe5aea4950485d23eddda58cf80268b2bf918858, Hooks $if739aceffec69fa2733946a3d319defaa354082d, GroupFactory $i27e910ceec1fa68ec715cc1afe5cb5d226f4c2dc) { parent::__construct($i31cc913adc2717e2346d503153c97449098831aa, $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, $i451f679eaafeecb81387b150019f0d9e0fa83d16, $i0d09b2a4f282150bf47b02f9f3d82586fe313844, $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b); $this->_unicodeFactory = $i57fd63e5200bfe7bc291e35785f410285397863d; $this->collectionFactory = $ibe5aea4950485d23eddda58cf80268b2bf918858; $this->_hooks = $if739aceffec69fa2733946a3d319defaa354082d; $this->_groupFactory = $i27e910ceec1fa68ec715cc1afe5cb5d226f4c2dc; } public function getHooks() { return $this->_hooks; } public function getGroupFactory() { return $this->_groupFactory; } public function getCollectionFactory() { return $this->collectionFactory; } public function getUnicodeFactory() { return $this->_unicodeFactory; } public function _initAction() { parent::_initAction(); $this->_setActiveMenu('Topefekt_Magesms::magesms_adminsms'); return $this; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_adminsms'); } } 