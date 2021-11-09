<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Indexer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Yosto\Arp\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Yosto\Arp\Model\Rule;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class IndexBuilder
 * @package Yosto\Arp\Model\Indexer
 */
class IndexBuilder
{
    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    protected $metadataPool;

    /**
     * CatalogRuleGroupWebsite columns list
     *
     * This array contain list of CatalogRuleGroupWebsite table columns
     *
     * @var array
     */
    protected $_arpRuleGroupWebsiteColumnsList = [
        'rule_id',
        'customer_group_id',
        'website_id'
    ];

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;


    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;


    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var Product[]
     */
    protected $loadedProducts;

    /**
     * @var int
     */
    protected $batchCount;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param PriceCurrencyInterface $priceCurrency
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Framework\Stdlib\DateTime $dateFormat
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param int $batchCount
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        RuleCollectionFactory $ruleCollectionFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        $batchCount = 1000
    ) {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->storeManager = $storeManager;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->logger = $logger;
       // $this->priceCurrency = $priceCurrency;
        $this->eavConfig = $eavConfig;
        $this->productFactory = $productFactory;
        $this->batchCount = $batchCount;
    }

    /**
     * Reindex by id
     *
     * @param int $id
     * @return void
     * @api
     */
    public function reindexById($id)
    {
        $this->reindexByIds([$id]);
    }

    /**
     * Reindex by ids
     *
     * @param array $ids
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     * @api
     */
    public function reindexByIds(array $ids)
    {
        try {
            $this->doReindexByIds($ids);
        } catch (\Exception $e) {
            $this->critical($e);
            throw new \Magento\Framework\Exception\LocalizedException(
                __("Arp rule indexing failed. See details in exception log.")
            );
        }
    }

    /**
     * Reindex by ids. Template method
     *
     * @param array $ids
     * @return void
     */
    protected function doReindexByIds($ids)
    {
        $this->cleanByIds($ids);

        foreach ($this->getActiveRules() as $rule) {
            foreach ($ids as $productId) {
                $this->applyRule($rule, $this->getProduct($productId));
            }
        }
    }

    /**
     * Full reindex
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     * @api
     */
    public function reindexFull()
    {
        try {
            $this->doReindexFull();
        } catch (\Exception $e) {
            $this->critical($e);
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()), $e);
        }
    }

    /**
     * Full reindex Template method
     *
     * @return void
     */
    protected function doReindexFull()
    {
        foreach ($this->getAllRules() as $rule) {
            $this->updateRuleProductData($rule);
        }

        $this->applyAllRules();
    }


    protected function cleanByIdsAndConditionType($productIds, $conditionType)
    {
        $tableName = $conditionType == "where_conditions"
            ? "yosto_arp_rule_where_product"
            : "yosto_arp_rule_what_product";

        $query = $this->connection->deleteFromSelect(
            $this->connection
                ->select()
                ->from($this->resource->getTableName($tableName), 'product_id')
                ->distinct()
                ->where('product_id IN (?)', $productIds),
            $this->resource->getTableName($tableName)
        );
        $this->connection->query($query);

        $query = $this->connection->deleteFromSelect(
            $this->connection->select()
                ->from($this->resource->getTableName($tableName), 'product_id')
                ->distinct()
                ->where('product_id IN (?)', $productIds),
            $this->resource->getTableName($tableName)
        );
        $this->connection->query($query);
    }
    /**
     * Clean by product ids
     *
     * @param array $productIds
     * @return void
     */
    protected function cleanByIds($productIds)
    {
        $this->cleanByIdsAndConditionType($productIds, "where_conditions");
        $this->cleanByIdsAndConditionType($productIds, "what_conditions");
    }


    protected function applyRuleByConditionType(Rule $rule, $product, $conditionType)
    {
        $tableName = $conditionType == "where_conditions"
            ? "yosto_arp_rule_where_product"
            : "yosto_arp_rule_what_product";
        $ruleId = $rule->getId();
        $productEntityId = $product->getId();
        $websiteIds = array_intersect($product->getWebsiteIds(), $rule->getWebsiteIds());

        if (!$rule->validate($product, $conditionType)) {
            return $this;
        }

        $this->connection->delete(
            $this->resource->getTableName($tableName),
            [
                $this->connection->quoteInto('rule_id = ?', $ruleId),
                $this->connection->quoteInto('product_id = ?', $productEntityId)
            ]
        );

        $customerGroupIds = $rule->getCustomerGroupIds();
        $sortOrder = (int)$rule->getSortOrder();
        $blockPosition = (int) $rule->getBlockPosition();

        $rows = [];
        try {
            foreach ($websiteIds as $websiteId) {
                foreach ($customerGroupIds as $customerGroupId) {
                    $rows[] = [
                        'rule_id' => $ruleId,
                        'website_id' => $websiteId,
                        'customer_group_id' => $customerGroupId,
                        'product_id' => $productEntityId,
                        'sort_order' => $sortOrder,
                        'block_position' => $blockPosition
                    ];

                    if (count($rows) == $this->batchCount) {
                        $this->connection->insertMultiple($this->getTable($tableName), $rows);
                        $rows = [];
                    }
                }
            }

            if (!empty($rows)) {
                $this->connection->insertMultiple($this->resource->getTableName($tableName), $rows);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        $this->applyAllRules($product);

        return $this;
    }

    /**
     * @param Rule $rule
     * @param Product $product
     * @return $this
     * @throws \Exception
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function applyRule(Rule $rule, $product)
    {
        $this->applyRuleByConditionType($rule, $product, "where_conditions");
        $this->applyRuleByConditionType($rule, $product, "what_conditions");
    }

    /**
     * @param string $tableName
     * @return string
     */
    protected function getTable($tableName)
    {
        return $this->resource->getTableName($tableName);
    }

    /**
     * @param Rule $rule
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function updateRuleProductData(Rule $rule)
    {
        $this->updateRuleProductDataByConditionType($rule, "where_conditions");
        $this->updateRuleProductDataByConditionType($rule, "what_conditions");

        return $this;
    }

    public function updateRuleProductDataByConditionType(Rule $rule, $conditionType)
    {
        $ruleId = $rule->getId();
        $tableName = $conditionType == "where_conditions"
            ? "yosto_arp_rule_where_product"
            : "yosto_arp_rule_what_product";
        if ($rule->getProductsFilter($conditionType)) {
            $this->connection->delete(
                $this->getTable($tableName),
                ['rule_id=?' => $ruleId, 'product_id IN (?)' => $rule->getProductsFilter($conditionType)]
            );
        } else {
            $this->connection->delete(
                $this->getTable($tableName),
                $this->connection->quoteInto('rule_id=?', $ruleId)
            );
        }

        if (!$rule->getIsActive()) {
            return $this;
        }

        $websiteIds = $rule->getWebsiteIds();
        if (!is_array($websiteIds)) {
            $websiteIds = explode(',', $websiteIds);
        }
        if (empty($websiteIds)) {
            return $this;
        }

        \Magento\Framework\Profiler::start('__MATCH_PRODUCTS__');
        $productIds = $rule->getMatchingProductIds($conditionType);
        \Magento\Framework\Profiler::stop('__MATCH_PRODUCTS__');

        $customerGroupIds = $rule->getCustomerGroupIds();
        $sortOrder = (int)$rule->getSortOrder();
        $blockPosition = (int) $rule->getBlockPosition();
        $rows = [];

        foreach ($productIds as $productId => $validationByWebsite) {
            foreach ($websiteIds as $websiteId) {
                if (empty($validationByWebsite[$websiteId])) {
                    continue;
                }
                foreach ($customerGroupIds as $customerGroupId) {
                    $rows[] = [
                        'rule_id' => $ruleId,
                        'website_id' => $websiteId,
                        'customer_group_id' => $customerGroupId,
                        'product_id' => $productId,
                        'sort_order' => $sortOrder,
                        'block_position' => $blockPosition
                    ];

                    if (count($rows) == $this->batchCount) {
                        $this->connection->insertMultiple($this->getTable($tableName), $rows);
                        $rows = [];
                    }
                }
            }
        }
        if (!empty($rows)) {
            $this->connection->insertMultiple($this->getTable($tableName), $rows);
        }

        return $this;
    }

    /**
     * @param Product|null $product
     * @throws \Exception
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function applyAllRules(Product $product = null)
    {
        return $this->updateArpRuleGroupWebsiteData();
    }

    /**
     * Update ArpRuleGroupWebsite data
     *
     * @return $this
     */
    protected function updateArpRuleGroupWebsiteData()
    {
        $this->connection->delete($this->getTable('yosto_arp_rule_group_website'), []);


        $select = $this->connection->select()->distinct(
            true
        )->from(
            $this->getTable('yosto_arp_rule_where_product'),
            $this->_arpRuleGroupWebsiteColumnsList
        );
        $query = $select->insertFromSelect(
            $this->getTable('yosto_arp_rule_group_website'),
            $this->_arpRuleGroupWebsiteColumnsList
        );

        $this->connection->query($query);

        return $this;
    }


    /**
     * @return $this
     */
    protected function getActiveRules()
    {
        return $this->ruleCollectionFactory->create()
            ->addFieldToFilter('is_active', 1);
    }

    /**
     * @return \Yosto\Arp\Model\ResourceModel\Rule\Collection
     */
    protected function getAllRules()
    {
        return $this->ruleCollectionFactory->create();
    }

    /**
     * @param int $productId
     * @return Product
     */
    protected function getProduct($productId)
    {
        if (!isset($this->loadedProducts[$productId])) {
            $this->loadedProducts[$productId] = $this->productFactory->create()->load($productId);
        }
        return $this->loadedProducts[$productId];
    }

    /**
     * @param \Exception $e
     * @return void
     */
    protected function critical($e)
    {
        $this->logger->critical($e);
    }


    /**
     * @return MetadataPool
     */
    private function getMetadataPool()
    {
        if (null === $this->metadataPool) {
            $this->metadataPool = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Framework\EntityManager\MetadataPool');
        }
        return $this->metadataPool;
    }
}