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
 namespace Topefekt\Magesms\Model; class Admins extends \Magento\Framework\Model\AbstractModel { protected function _construct() { $this->_init('Topefekt\Magesms\Model\ResourceModel\Admins'); } public function validate() { $ieeea3fa58a065e13acdb42aab551831a98e9444c = array(); if (empty($this->getName())) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('Invalid name'); } if (empty($this->getNumber())) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('Invalid number'); } elseif (!preg_match('/^[0-9]{7,18}$/', $this->getNumber())) { $ieeea3fa58a065e13acdb42aab551831a98e9444c[] = __('Invalid number'); } if (empty($ieeea3fa58a065e13acdb42aab551831a98e9444c)) { return true; } return $ieeea3fa58a065e13acdb42aab551831a98e9444c; } public function afterDelete() { if ($this->getId()) { } return parent::afterDelete(); } } 