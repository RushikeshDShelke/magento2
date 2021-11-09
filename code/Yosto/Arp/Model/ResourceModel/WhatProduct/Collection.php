<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\ResourceModel\WhatProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Yosto\Arp\Model\ResourceModel\WhatProduct
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Yosto\Arp\Model\WhatProduct',
            'Yosto\Arp\Model\ResourceModel\WhatProduct'
        );
    }
}