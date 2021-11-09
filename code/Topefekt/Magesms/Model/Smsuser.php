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
 namespace Topefekt\Magesms\Model; class Smsuser extends \Magento\Framework\Model\AbstractModel { protected function _construct() { $this->_init('Topefekt\Magesms\Model\ResourceModel\Smsuser'); } public function validate() { $ieeea3fa58a065e13acdb42aab551831a98e9444c = []; if ($this->getData('deliveryemail') && !\Zend_Validate::is($this->getData('deliveryemail'), 'EmailAddress')) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('Invalid e-mail'); } if (!\Zend_Validate::is($this->getData('email'), 'EmailAddress')) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('Invalid e-mail'); } if (!$this->getId() && $this->getData('agree') != 1) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('You have to agree with licence terms.'); } if (empty($ieeea3fa58a065e13acdb42aab551831a98e9444c)) { return true; } return $ieeea3fa58a065e13acdb42aab551831a98e9444c; } public function getUser() { return $this->getData('user'); } public function getPasswd() { return $this->getData('passwd'); } } 