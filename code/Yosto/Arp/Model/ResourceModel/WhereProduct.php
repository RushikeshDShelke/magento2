<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class WhereProduct
 * @package Yosto\Arp\Model\ResourceModel
 */
class WhereProduct extends AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('yosto_arp_rule_what_product', 'rule_product_id');
    }
}