<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DB\Select;
use Magento\Rule\Model\ResourceModel\AbstractResource;
use Magento\Framework\EntityManager\EntityManager;

/**
 * Class Rule
 * @package Yosto\Arp\Model\ResourceModel
 */
class Rule extends AbstractResource
{

    /**
     * Store associated with rule entities information map
     *
     * @var array
     */
    protected $_associatedEntitiesMap = [];

    /**
     * @var array
     */
    protected $customerGroupIds = [];

    /**
     * @var array
     */
    protected $websiteIds = [];

    /**
     * Magento string lib
     *
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    protected $string;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\StringUtils $string,
        $connectionName = null
    ) {
        $this->string = $string;
        $this->_associatedEntitiesMap = $this->getAssociatedEntitiesMap();
        parent::__construct($context, $connectionName);
    }
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('yosto_arp_rule', 'rule_id');
    }


    /**
     * @param \Magento\Framework\Model\AbstractModel $rule
     * @return $this
     */
    protected function _afterDelete(\Magento\Framework\Model\AbstractModel $rule)
    {
        $connection = $this->getConnection();
        $connection->delete(
            $this->getTable('yosto_arp_rule_group_website'),
            ['rule_id=?' => $rule->getId()]
        );
        return parent::_afterDelete($rule);
    }


    public function getRulesFromProductByBlockPosition(
        $websiteId,
        $customerGroupId,
        $productId,
        $conditionType,
        $blockPosition
    ) {
        $tableName = $conditionType == "where_conditions"
            ? "yosto_arp_rule_where_product"
            : "yosto_arp_rule_what_product";

        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getTable($tableName) . ' as wp')
            ->join(
                $this->getTable('yosto_arp_rule') . ' as rule',
                 'rule.rule_id = wp.rule_id',
                [
                    'max_products' => 'rule.max_products',
                    'sort_by' => 'rule.sort_by',
                    'layout' => 'rule.layout',
                    'block_title' => 'rule.block_title',
                    "show_cart_button" => 'rule.show_cart_button'
                ]
            )
            ->where('wp.website_id = ?', $websiteId)
            ->where('wp.customer_group_id = ?', $customerGroupId)
            ->where('wp.product_id = ?', $productId)
            ->where('wp.block_position = ?', $blockPosition);
        return $connection->fetchAll($select);
    }
    /**
     * @param $websiteId
     * @param $customerGroupId
     * @param $productId
     * @param $conditionType
     * @return array
     */
    public function getRulesFromProduct($websiteId, $customerGroupId, $productId, $conditionType)
    {
        $tableName = $conditionType == "where_conditions"
            ? "yosto_arp_rule_where_product"
            : "yosto_arp_rule_what_product";

        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getTable($tableName))
            ->where('website_id = ?', $websiteId)
            ->where('customer_group_id = ?', $customerGroupId)
            ->where('product_id = ?', $productId);

        return $connection->fetchAll($select);
    }

//    /**
//     * @param AbstractModel $object
//     * @return void
//     * @deprecated
//     */
//    public function loadCustomerGroupIds(AbstractModel $object)
//    {
//        if (!$this->customerGroupIds) {
//            $this->customerGroupIds = (array)$this->getCustomerGroupIds($object->getId());
//        }
//        $object->setData('customer_group_ids', $this->customerGroupIds);
//    }
//
//    /**
//     * @param AbstractModel $object
//     * @return void
//     * @deprecated
//     */
//    public function loadWebsiteIds(AbstractModel $object)
//    {
//        if (!$this->websiteIds) {
//            $this->websiteIds = (array)$this->getWebsiteIds($object->getId());
//        }
//
//        $object->setData('website_ids', $this->websiteIds);
//    }

    /**
     * Load an object
     *
     * @param \Yosto\Arp\Model\Rule|AbstractModel $object
     * @param mixed $value
     * @param string $field field to load by (defaults to model id)
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $this->getEntityManager()->load($object, $value);
        return $this;
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->beforeSave();
        $this->getEntityManager()->save($object);
        return $this;
    }

    /**
     * Delete the object
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function delete(AbstractModel $object)
    {
        $this->getEntityManager()->delete($object);
        $object->afterDelete();
        return $this;
    }

    /**
     * @return array
     * @deprecated
     */
    private function getAssociatedEntitiesMap()
    {
        if (!$this->_associatedEntitiesMap) {
            $this->_associatedEntitiesMap = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Yosto\Arp\Model\ResourceModel\Rule\AssociatedEntityMap')
                ->getData();
        }
        return $this->_associatedEntitiesMap;
    }

    /**
     * @return \Magento\Framework\EntityManager\EntityManager
     * @deprecated
     */
    private function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\EntityManager\EntityManager::class);
        }
        return $this->entityManager;
    }

}
