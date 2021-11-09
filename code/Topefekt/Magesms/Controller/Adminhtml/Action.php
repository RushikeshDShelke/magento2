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
namespace Topefekt\Magesms\Controller\Adminhtml; use Magento\Backend\App\Action\Context; use Magento\Framework\Registry; use Magento\Framework\View\Result\PageFactory; use Magento\Framework\App\RequestInterface; use Topefekt\Magesms\Model\Smsprofile; use Topefekt\Magesms\Model\Api; use Topefekt\Magesms\Helper\Data; abstract class Action extends \Magento\Backend\App\Action { protected $_resultPageFactory; protected $_api; protected $_mageHelper; protected $profile; protected $_coreRegistry; public function __construct(Context $i31cc913adc2717e2346d503153c97449098831aa, PageFactory $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, Smsprofile $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, Api $i451f679eaafeecb81387b150019f0d9e0fa83d16, Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b) { parent::__construct($i31cc913adc2717e2346d503153c97449098831aa); $this->_resultPageFactory = $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1; $this->profile = $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18; $this->_api = $i451f679eaafeecb81387b150019f0d9e0fa83d16; $this->_mageHelper = $i0d09b2a4f282150bf47b02f9f3d82586fe313844; $this->_coreRegistry = $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b; } public function getApi() { return $this->_api; } public function getMageHelper() { return $this->_mageHelper; } public function getMessageManager() { return $this->messageManager; } public function getSession() { return $this->_session; } public function dispatch(RequestInterface $ib2c014c384e400e98e6977efa41c20d14e2c7dea) { if (!in_array($ib2c014c384e400e98e6977efa41c20d14e2c7dea->getControllerName(), ['index', 'profile']) && !$this->profile->user->getUser()) { $this->getMessageManager()->addSuccessMessage(__('Not registered yet? Create account now!')); return $this->_redirect('*/profile/index'); } return parent::dispatch($ib2c014c384e400e98e6977efa41c20d14e2c7dea); } public function _initAction() { $this->_view->loadLayout(); $this->_addBreadcrumb(__('MageSMS'), __('MageSMS')); return $this; } public function getCoreRegistry() { return $this->_coreRegistry; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms'); } } 