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
namespace Topefekt\Magesms\Controller\Adminhtml\History; class Exportcsv extends \Topefekt\Magesms\Controller\Adminhtml\History { public function execute() { $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd = $this->getHistoryFactory()->create(); $i3ba0e99f358e315835fe8aca63713b157cd07b3f = $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd->getCollection()->getConnection(); $i7af9c0bf5c8f0878a0f7c5463d75397834eda9fa = $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd->getCollection()->getMainTable(); $i7fb1970287c90ac449c81c05360a581fcdd5a6af = $i3ba0e99f358e315835fe8aca63713b157cd07b3f->describeTable($i7af9c0bf5c8f0878a0f7c5463d75397834eda9fa); $i25f6ca5af884f5fb6975c45037ba66d5f6838523 = ''; $ia61712c27ea241bd7a543dc2b02ea572274d0322 = array(); foreach ($i7fb1970287c90ac449c81c05360a581fcdd5a6af as $i8f64ce2d7476196ba335784d391aa0427bb41857=>$ia8a35a47a8e61218e15d1a33dac64bdc2449c01a) { $ia61712c27ea241bd7a543dc2b02ea572274d0322[] = '"'.$i8f64ce2d7476196ba335784d391aa0427bb41857.'"'; } $i25f6ca5af884f5fb6975c45037ba66d5f6838523.= implode(',', $ia61712c27ea241bd7a543dc2b02ea572274d0322)."\n"; $i70f8c28e8955b2f1f7dc0e997c564e780d249bea = $i2e5aa867ea7c6f8ed9ffffe56b63b837364669dd->getCollection(); foreach ($i70f8c28e8955b2f1f7dc0e997c564e780d249bea as $iff7e46827cbb6547116c592bf800f4687428abf9) { $ia61712c27ea241bd7a543dc2b02ea572274d0322 = array(); foreach ($iff7e46827cbb6547116c592bf800f4687428abf9->getData() as $i8f64ce2d7476196ba335784d391aa0427bb41857) { $ia61712c27ea241bd7a543dc2b02ea572274d0322[] = '"' . str_replace(array('"', '\\', "\n", "\r", "\n\r", "\r\n"), array('""', '\\\\', ' ', ' ', ' ', ' '), $i8f64ce2d7476196ba335784d391aa0427bb41857) . '"'; } $i25f6ca5af884f5fb6975c45037ba66d5f6838523.= implode(',', $ia61712c27ea241bd7a543dc2b02ea572274d0322)."\n"; } header('Content-Type: text/csv; charset=UTF-8'); header('Content-Disposition: attachment; filename="smshistory.csv'); die($i25f6ca5af884f5fb6975c45037ba66d5f6838523); } } 