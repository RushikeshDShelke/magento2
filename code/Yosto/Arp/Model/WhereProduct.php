<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class WhereProduct
 * @package Yosto\Arp\Model
 */
class WhereProduct extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Yosto\Arp\Model\ResourceModel\WhereProduct');
    }
}