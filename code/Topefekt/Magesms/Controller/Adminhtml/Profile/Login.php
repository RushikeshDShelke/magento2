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
 namespace Topefekt\Magesms\Controller\Adminhtml\Profile; class Login extends \Topefekt\Magesms\Controller\Adminhtml\Action { public function execute() { $i065df39c07d6c930a4781ba0b0f312703847fa81 = $this->getRequest()->getParam('username'); $i54d1b2514929b4ead571e37199167cb71517da24 = $this->getRequest()->getParam('password'); $ia61712c27ea241bd7a543dc2b02ea572274d0322 = $this->_api->serverPost('action=login&username='.urlencode($i065df39c07d6c930a4781ba0b0f312703847fa81).'&password='.urlencode($i54d1b2514929b4ead571e37199167cb71517da24)); if ($ia61712c27ea241bd7a543dc2b02ea572274d0322['errno'] != 1) { $this->messageManager->addErrorMessage(__($ia61712c27ea241bd7a543dc2b02ea572274d0322['error'])); } else { $idd5406ca9a19e1687923f28236de86b1936c5757 = $this->_objectManager->create('Topefekt\Magesms\Model\Smsuser'); $idd5406ca9a19e1687923f28236de86b1936c5757->addData( array( 'user' => $i065df39c07d6c930a4781ba0b0f312703847fa81, 'passwd' => $i54d1b2514929b4ead571e37199167cb71517da24, 'email' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][0], 'companyname' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][1], 'regtype' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][1] ? 'firm' : 'person', 'addressstreet' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][2], 'addresscity' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][3], 'addresszip' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][4], 'companyid' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][5], 'companyvat' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][6], 'country' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][7], 'firstname' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][8], 'lastname' => $ia61712c27ea241bd7a543dc2b02ea572274d0322['data'][9] ) )->save(); $this->messageManager->addSuccessMessage(__($ia61712c27ea241bd7a543dc2b02ea572274d0322['error'])); } $this->_redirect('*/*/'); } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_profile'); } } 