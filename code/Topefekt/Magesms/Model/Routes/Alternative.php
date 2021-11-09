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
 namespace Topefekt\Magesms\Model\Routes; class Alternative extends \Magento\Framework\Model\AbstractModel { protected function _construct() { $this->_init('Topefekt\Magesms\Model\ResourceModel\Routes\Alternative'); } public function validate() { $ieeea3fa58a065e13acdb42aab551831a98e9444c = []; if (!\Zend_Validate::is($this->getTextsender(), 'NotEmpty')) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('possible characters: ').'a-z A-Z 0-9 _ .'; } elseif (!preg_match('/(?!^\d+$)^[0-9a-zA-Z_.]{3,11}$/', $this->getTextsender())) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('possible characters: ').'a-z A-Z 0-9 _ .'; } if (empty($ieeea3fa58a065e13acdb42aab551831a98e9444c)) { return true; } return $ieeea3fa58a065e13acdb42aab551831a98e9444c; } public function _beforeSave() { $ibdd27a8dd714410289189d318feb96fe6ed8e07f = $this->validate(); if (is_array($ibdd27a8dd714410289189d318feb96fe6ed8e07f) && count($ibdd27a8dd714410289189d318feb96fe6ed8e07f)) { \throwException(implode('<br />', $ibdd27a8dd714410289189d318feb96fe6ed8e07f)); } return parent::_beforeSave(); } } 