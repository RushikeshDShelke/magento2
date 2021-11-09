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
 namespace Topefekt\Magesms\Setup; use Magento\Framework\Setup\UninstallInterface; use Magento\Framework\Setup\SchemaSetupInterface; use Magento\Framework\Setup\ModuleContextInterface; class Uninstall implements UninstallInterface { public function uninstall(SchemaSetupInterface $iae3e2ffb6c51b544cd0688f6a7936cf83969b8a9, ModuleContextInterface $i31cc913adc2717e2346d503153c97449098831aa) { $iae3e2ffb6c51b544cd0688f6a7936cf83969b8a9->startSetup(); $iae3e2ffb6c51b544cd0688f6a7936cf83969b8a9->endSetup(); } }