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
 namespace Topefekt\Magesms\Model\ResourceModel\Ownnumbersender; use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection; class Collection extends AbstractCollection { public function _construct() { $this->_init('Topefekt\Magesms\Model\Ownnumbersender', 'Topefekt\Magesms\Model\ResourceModel\Ownnumbersender'); } } 