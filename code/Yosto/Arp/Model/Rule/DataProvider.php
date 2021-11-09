<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule;

use Yosto\Arp\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Yosto\Arp\Model\Rule;
use Yosto\Arp\Model\Rule\Metadata\ValueProvider;

/**
 * Class DataProvider
 * @package Yosto\Arp\Model\Rule
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    protected $loadedData;

    protected $dataPersistor;

    protected $metadataValues;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        ValueProvider $metadataValues,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->metadataValues = $metadataValues;
        $meta = $this->getMetadataValues();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var Rule $model */
        foreach ($items as $model) {
            $model->load($model->getId());
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('yosto_arp_rule');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('yosto_arp_rule');
        }
        
        return $this->loadedData;
    }

    public function getMetadataValues()
    {
        return $this->metadataValues->getMetadataValues();
    }
}
