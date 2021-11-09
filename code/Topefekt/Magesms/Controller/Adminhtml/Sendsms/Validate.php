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
 namespace Topefekt\Magesms\Controller\Adminhtml\Sendsms; use Magento\Backend\App\Action\Context; use Magento\Framework\DataObject; use Magento\Framework\Registry; use Magento\Framework\View\Result\PageFactory; use Magento\Framework\Controller\Result\JsonFactory; use Topefekt\Magesms\Helper\Data; use Topefekt\Magesms\Model\Api; use Topefekt\Magesms\Model\Smsprofile; class Validate extends \Topefekt\Magesms\Controller\Adminhtml\Action { protected $resultJsonFactory; public function __construct(Context $i31cc913adc2717e2346d503153c97449098831aa, PageFactory $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, Smsprofile $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, Api $i451f679eaafeecb81387b150019f0d9e0fa83d16, Data $i0d09b2a4f282150bf47b02f9f3d82586fe313844, Registry $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b, JsonFactory $i9a280ebe4bf63f298222a5d64da69db4e648d487) { parent::__construct($i31cc913adc2717e2346d503153c97449098831aa, $i3f1db03e4dfdd28ff5ba1a1f709c3a2e135b99b1, $i6abff7c4dab2aa28578ae1dc49699ba6b1d18c18, $i451f679eaafeecb81387b150019f0d9e0fa83d16, $i0d09b2a4f282150bf47b02f9f3d82586fe313844, $ie9fe5cdc9fc7093987f4d41ad4cae3554e64e17b); $this->resultJsonFactory = $i9a280ebe4bf63f298222a5d64da69db4e648d487; } public function execute() { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e = new DataObject(); $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(false); if (!$this->getRequest()->getPost()) { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(true); return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } if (!$this->getRequest()->getParam('text')) { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(true); $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setMessage(__('Fill in SMS text.')); return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_sendsms'); } } 