<?php
namespace M2s\Vouchagram\Model;

class Vouchagram extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('M2s\Vouchagram\Model\ResourceModel\Vouchagram');
    }
}
?>