<?php
namespace  M2s\Vouchagram\Model\ResourceModel;

class Vouchagram extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('vouchagram', 'entity_id');
    }
}
?>