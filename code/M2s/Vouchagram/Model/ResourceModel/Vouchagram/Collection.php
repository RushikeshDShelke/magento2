<?php

namespace  M2s\Vouchagram\Model\ResourceModel\Vouchagram;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('M2s\Vouchagram\Model\Vouchagram', 'M2s\Vouchagram\Model\ResourceModel\Vouchagram');
    }

}
?>