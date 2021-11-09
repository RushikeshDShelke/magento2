<?php

namespace Manish\Orderstatus\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Widget\Container
{



    public function __construct(\Magento\Backend\Block\Widget\Context $context,array $data = [])
    {
        parent::__construct($context, $data);
    }

      public function getSataus()
    {    $manager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $orderstatus = array();
        $status_collection = $manager->create('Magento\Sales\Model\ResourceModel\Order\Status\Collection'); 
        $orderstatus['default'] =  /* @escapeNotVerified */__('Current State');
        foreach ($status_collection as $status) {
            $key = $status["status"];
            $orderstatus[$key] = $status["label"];
        }
        return $orderstatus;
    }

}
