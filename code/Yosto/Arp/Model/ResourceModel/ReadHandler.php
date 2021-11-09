<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Model\ResourceModel;

use Yosto\Arp\Model\ResourceModel\Rule;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\AttributeInterface;

/**
 * Class ReadHandler
 */
class ReadHandler implements AttributeInterface
{
    /**
     * @var Rule
     */
    protected $ruleResource;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @param Rule $ruleResource
     * @param MetadataPool $metadataPool
     */
    public function __construct(
        Rule $ruleResource,
        MetadataPool $metadataPool
    ) {
        $this->ruleResource = $ruleResource;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @param string $entityType
     * @param array $entityData
     * @param array $arguments
     * @return array
     * @throws \Exception
     */
    public function execute($entityType, $entityData, $arguments = [])
    {
        $linkField = $this->metadataPool->getMetadata($entityType)->getLinkField();
        $entityId = $entityData[$linkField];

        $entityData['customer_group_ids'] = $this->ruleResource->getCustomerGroupIds($entityId);
        $entityData['website_ids'] = $this->ruleResource->getWebsiteIds($entityId);

        return $entityData;
    }
}
