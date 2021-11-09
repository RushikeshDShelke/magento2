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
 namespace Topefekt\Magesms\Controller\Adminhtml\Profile\Admin; use Magento\Backend\App\Action\Context; use Magento\Framework\DataObject; use Magento\Framework\View\Result\PageFactory; use Magento\Framework\Controller\Result\JsonFactory; use Topefekt\Magesms\Helper\Data; use Topefekt\Magesms\Model\Api; use Topefekt\Magesms\Model\Smsprofile; class Save extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $this->_redirect('*/*/'); } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_profile'); } } 