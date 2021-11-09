<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\StoreManagerInterface;
use Yosto\Arp\Helper\ConditionConverter;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\FormFactory;
use Yosto\Arp\Model\Rule\Condition\WhatCombineFactory;
use Yosto\Arp\Model\Rule\Condition\WhereCombineFactory;
use Yosto\Arp\Api\Data\RuleInterface;

/**
 * @method \Yosto\Arp\Model\ResourceModel\Rule _getResource()
 * @method \Yosto\Arp\Model\ResourceModel\Rule getResource()
 * Class Rule
 * @package Yosto\Arp\Model
 */
class Rule extends AbstractModel implements RuleInterface
{

    protected $_idFieldName = "rule_id";
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'yosto_arp_rule';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getRule() in this case
     *
     * @var string
     */
    protected $_eventObject = 'rule';

    /**
     * @var \Magento\CatalogRule\Model\Data\Condition\Converter
     */
    protected $_ruleConditionConverter;
    /**
     * @var \Yosto\Arp\Model\Rule\Condition\WhatCombineFactory
     */
    protected $_whatCombineFactory;

    /**
     * @var \Yosto\Arp\Model\Rule\Condition\WhereCombineFactory
     */
    protected $_whereCombineFactory;

    /**
     * Store rule form instance
     *
     * @var \Magento\Framework\Data\Form
     */
    protected $_form;

    /**
     * Form factory
     *
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $_formFactory;

    /**
     * Store rule combine conditions model
     *
     * @var \Magento\Rule\Model\Condition\Combine
     */
    protected $_whereConditions;

    /**
     * Store rule combine conditions model
     *
     * @var \Magento\Rule\Model\Condition\Combine
     */
    protected $_whatConditions;

    /**
     * Store matched product Ids for where conditions
     *
     * @var array
     */
    protected $_matchWhereConditionsProductIds;
    /**
     * Store matched product Ids for what conditions
     *
     * @var array
     */
    protected $_matchWhatConditionsProductIds;

    /**
     * @var \Magento\Framework\Model\ResourceModel\Iterator
     */
    protected $_resourceIterator;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    protected $_ruleProductProcessor;
    /**
     * Limitation for products collection
     *
     * @var int|array|null
     */
    protected $_whereConditionsProductsFilter = null;
    protected $_whatConditionsProductsFilter = null;
    public function __construct(
        ConditionConverter $ruleConditionConverter,
        WhatCombineFactory $whatCombineFactory,
        WhereCombineFactory $whereCombineFactory,
        FormFactory $formFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\Iterator $resourceIterator,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor $ruleProductProcessor,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_ruleConditionConverter = $ruleConditionConverter;
        $this->_whatCombineFactory = $whatCombineFactory;
        $this->_whereCombineFactory = $whereCombineFactory;
        $this->_formFactory = $formFactory;
        $this->_productFactory = $productFactory;
        $this->_resourceIterator = $resourceIterator;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_ruleProductProcessor = $ruleProductProcessor;
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Yosto\Arp\Model\ResourceModel\Rule');
    }


    /**
     * Prepare data before saving
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function beforeSave()
    {

        // Serialize What conditions
        if ($this->getWhatConditions()) {
            $this->setWhatConditionsSerialized(serialize($this->getWhatConditions()->asArray()));
            $this->_whatConditions = null;
        }

        // Serialize actions
        if ($this->getWhereConditions()) {
            $this->setWhereConditionsSerialized(serialize($this->getWhereConditions()->asArray()));
            $this->_whereConditions = null;
        }

        /**
         * Prepare website Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasWebsiteIds()) {
            $websiteIds = $this->getWebsiteIds();
            if (is_string($websiteIds) && !empty($websiteIds)) {
                $this->setWebsiteIds(explode(',', $websiteIds));
            }
        }

        /**
         * Prepare customer group Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasCustomerGroupIds()) {
            $groupIds = $this->getCustomerGroupIds();
            if (is_string($groupIds) && !empty($groupIds)) {
                $this->setCustomerGroupIds(explode(',', $groupIds));
            }
        }

        parent::beforeSave();
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function afterSave()
    {
        if ($this->isObjectNew()) {
            $this->getMatchingProductIdsForWhereConditions();
            if (!empty($this->_matchWhereConditionsProductIds) && is_array($this->_matchWhereConditionsProductIds)) {
                $this->_ruleProductProcessor->reindexList($this->_matchWhereConditionsProductIds);
            }
        } else {
            $this->_ruleProductProcessor->getIndexer()->invalidate();
        }
        return parent::afterSave();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function afterDelete()
    {
        $this->_ruleProductProcessor->getIndexer()->invalidate();
        return parent::afterDelete();
    }
    /**
     * Check if rule behavior changed
     *
     * @return bool
     */
    public function isRuleBehaviorChanged()
    {
        if (!$this->isObjectNew()) {
            $arrayDiff = $this->dataDiff($this->getOrigData(), $this->getData());
            unset($arrayDiff['name']);
            unset($arrayDiff['block_title']);
            unset($arrayDiff['layout']);
            unset($arrayDiff['max_products']);
            unset($arrayDiff['sort_by']);
            if (empty($arrayDiff)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get array with data differences
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    protected function dataDiff($array1, $array2)
    {
        $result = [];
        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                if (is_array($value)) {
                    if ($value != $array2[$key]) {
                        $result[$key] = true;
                    }
                } else {
                    if ($value != $array2[$key]) {
                        $result[$key] = true;
                    }
                }
            } else {
                $result[$key] = true;
            }
        }
        return $result;
    }


    /**
     * Get rule_id
     * @return string
     */
    public function getRuleId()
    {
        return $this->getData(self::RULE_ID);
    }

    /**
     * Set rule_id
     * @param string $ruleId
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setRuleId($ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * Get is_active
     * @return string
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $is_active
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }

    /**
     * Get block_position
     * @return string
     */
    public function getBlockPosition()
    {
        return $this->getData(self::BLOCK_POSITION);
    }

    /**
     * Set block_position
     * @param string $block_position
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setBlockPosition($block_position)
    {
        return $this->setData(self::BLOCK_POSITION, $block_position);
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get where_conditions_serialized
     * @return string
     */
    public function getRuleWhereConditions()
    {
        return $this->getRuleConditionConverter()->arrayToDataModel(
            $this->getWhereConditions()->asArray(), 'where_conditions'
        );
    }

    /**
     * Set where_conditions_serialized
     * @param \Magento\CatalogRule\Api\Data\ConditionInterface $condition
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setRuleWhereConditions($condition)
    {
        $this->getWhereConditions()
            ->setConditions([])
            ->loadArray($this->getRuleConditionConverter()->dataModelToArray($condition));
        return $this;
    }

    /**
     * Get what_conditions_serialized
     * @return string
     */
    public function getRuleWhatConditions()
    {
        return $this->getRuleConditionConverter()->arrayToDataModel(
            $this->getWhatConditions()->asArray(), "what_conditions"
        );
    }

    /**
     * Set what_conditions_serialized
     * @param \Magento\CatalogRule\Api\Data\ConditionInterface $condition
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setRuleWhatConditions($condition)
    {
        $this->getWhatConditions()
            ->setConditions([])
            ->loadArray($this->getRuleConditionConverter()->dataModelToArray($condition));
        return $this;
    }

    /**
     * Get sort order
     * @return string
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set sort order
     * @param string $sortOrder
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Get block_title
     * @return string
     */
    public function getBlockTitle()
    {
        return $this->getData(self::BLOCK_TITLE);
    }

    /**
     * Set block_title
     * @param string $block_title
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setBlockTitle($block_title)
    {
        return $this->setData(self::BLOCK_TITLE, $block_title);
    }

    /**
     * Get layout
     * @return string
     */
    public function getLayout()
    {
        return $this->getData(self::LAYOUT);
    }

    /**
     * Set layout
     * @param string $layout
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setLayout($layout)
    {
        return $this->setData(self::LAYOUT, $layout);
    }

    /**
     * Get max_products
     * @return string
     */
    public function getMaxProducts()
    {
        return $this->getData(self::MAX_PRODUCTS);
    }

    /**
     * Set max_products
     * @param string $max_products
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setMaxProducts($max_products)
    {
        return $this->setData(self::MAX_PRODUCTS, $max_products);
    }

    /**
     * Get sort_by
     * @return string
     */
    public function getSortBy()
    {
        return $this->getData(self::SORT_BY);
    }

    /**
     * Set sort_by
     * @param string $sort_by
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    public function setSortBy($sort_by)
    {
        return $this->setData(self::SORT_BY, $sort_by);
    }

    /**
     * Getter for rule conditions collection
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getWhatConditionsInstance()
    {
        return $this->_whatCombineFactory->create();
    }
    /**
     * Getter for rule conditions collection
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getWhereConditionsInstance()
    {
        return $this->_whereCombineFactory->create();
    }


    /**
     * @return Converter|mixed
     */
    private function getRuleConditionConverter()
    {
        if (null === $this->_ruleConditionConverter) {
            $this->_ruleConditionConverter = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Yosto\Arp\Helper\ConditionConverter::class);
        }
        return $this->_ruleConditionConverter;
    }
    /**
     * @param string $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '', $conditionType)
    {
        if ($conditionType === 'where_conditions') {
            return $formName . '_where_conditions_fieldset_' . $this->getId();
        } else {
            return $formName . '_what_conditions_fieldset_' . $this->getId();
        }
    }

    /**
     * Set rule combine where conditions model
     *
     * @param \Magento\Rule\Model\Condition\Combine $conditions
     * @return $this
     */
    public function setWhereConditions($conditions)
    {
        $this->_whereConditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine where conditions model
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getWhereConditions()
    {
        if (empty($this->_whereConditions)) {
            $this->_resetWhereConditions();
        }

        // Load rule conditions if it is applicable
        if ($this->hasWhereConditionsSerialized()) {
            $conditions = $this->getWhereConditionsSerialized();
            if (!empty($conditions)) {
                $conditions = unserialize($conditions);
                if (is_array($conditions) && !empty($conditions)) {
                    $this->_whereConditions->loadArray($conditions);
                }
            }
            $this->unsWhereConditionsSerialized();
        }

        return $this->_whereConditions;
    }



    /**
     * Reset rule combine where conditions
     *
     * @param null|\Yosto\Arp\Model\Rule\Condition\WhereCombine $conditions
     * @return $this
     */
    protected function _resetWhereConditions($conditions = null)
    {
        if (null === $conditions) {
            $conditions = $this->getWhereConditionsInstance();
        }
        $conditions->setRule($this)->setId('1')->setPrefix('where_conditions');
        $this->setWhereConditions($conditions);

        return $this;
    }


    /**
     * Set rule combine what conditions model
     *
     * @param \Magento\Rule\Model\Condition\Combine $conditions
     * @return $this
     */
    public function setWhatConditions($conditions)
    {
        $this->_whatConditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine what conditions model
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getWhatConditions()
    {
        if (empty($this->_whatConditions)) {
            $this->_resetWhatConditions();
        }

        // Load rule conditions if it is applicable
        if ($this->hasWhatConditionsSerialized()) {
            $conditions = $this->getWhatConditionsSerialized();
            if (!empty($conditions)) {
                $conditions = unserialize($conditions);
                if (is_array($conditions) && !empty($conditions)) {
                    $this->_whatConditions->loadArray($conditions);
                }
            }
            $this->unsWhatConditionsSerialized();
        }

        return $this->_whatConditions;
    }



    /**
     * Reset rule combine what conditions
     *
     * @param null|\Magento\Rule\Model\Condition\Combine $conditions
     * @return $this
     */
    protected function _resetWhatConditions($conditions = null)
    {
        if (null === $conditions) {
            $conditions = $this->getWhatConditionsInstance();
        }
        $conditions->setRule($this)->setId('1')->setPrefix('what_conditions');
        $this->setWhatConditions($conditions);

        return $this;
    }


    /**
     * Rule form getter
     *
     * @return \Magento\Framework\Data\Form
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = $this->_formFactory->create();
        }
        return $this->_form;
    }

    /**
     * Initialize rule model data from array
     *
     * @param array $data
     * @return $this
     */
    public function loadPost(array $data)
    {
        $arr = $this->_convertFlatToRecursive($data);
        if (isset($arr['where_conditions'])) {
            $this->getWhereConditions()->setConditions([])->loadArray($arr['where_conditions'][1],'where_conditions');
        }
        if (isset($arr['what_conditions'])) {
            $this->getWhatConditions()->setConditions([])->loadArray($arr['what_conditions'][1], 'what_conditions');
        }
        return $this;
    }

    /**
     * Set specified data to current rule.
     * Set conditions and actions recursively.
     *
     * @param array $data
     * @return array
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function _convertFlatToRecursive(array $data)
    {
        $arr = [];
        foreach ($data as $key => $value) {
            if (($key === 'what_conditions' || $key === "where_conditions") && is_array($value)) {
                foreach ($value as $id => $data) {
                    $path = explode('--', $id);
                    $node = & $arr;
                    for ($i = 0, $l = sizeof($path); $i < $l; $i++) {
                        if (!isset($node[$key][$path[$i]])) {
                            $node[$key][$path[$i]] = [];
                        }
                        $node = & $node[$key][$path[$i]];
                    }
                    foreach ($data as $k => $v) {
                        $node[$k] = $v;
                    }
                }
            } else {

                $this->setData($key, $value);
            }
        }

        return $arr;
    }

    /**
     * Validate rule conditions to determine if rule can run
     *
     * @param \Magento\Framework\DataObject $object
     * @return bool
     */
    public function validate(\Magento\Framework\DataObject $object, $key)
    {
        if ($key === 'what_conditions') {
            return $this->getWhatConditions()->validate($object) ;
        } else {
            return $this->getWhereConditions()->validate($object) ;
        }
    }



    /**
     * Validate rule data
     *
     * @param \Magento\Framework\DataObject $dataObject
     * @return bool|string[] - return true if validation passed successfully. Array with errors description otherwise
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function validateData(\Magento\Framework\DataObject $dataObject)
    {
        $result = [];

        if ($dataObject->hasWebsiteIds()) {
            $websiteIds = $dataObject->getWebsiteIds();
            if (empty($websiteIds)) {
                $result[] = __('Please specify a website.');
            }
        }
        if ($dataObject->hasCustomerGroupIds()) {
            $customerGroupIds = $dataObject->getCustomerGroupIds();
            if (empty($customerGroupIds)) {
                $result[] = __('Please specify Customer Groups.');
            }
        }

        return !empty($result) ? $result : true;
    }


    /**
     * Get rule associated website Ids
     *
     * @return array
     */
    public function getWebsiteIds()
    {
        if (!$this->hasWebsiteIds()) {
            $websiteIds = $this->_getResource()->getWebsiteIds($this->getId());
            $this->setData('website_ids', (array)$websiteIds);
        }
        return $this->_getData('website_ids');
    }

    /**
     * Get sales rule customer group Ids
     *
     * @return array
     */
    public function getCustomerGroupIds()
    {
        if (!$this->hasCustomerGroupIds()) {
            $customerGroupIds = $this->_getResource()->getCustomerGroupIds($this->getId());
            $this->setData('customer_group_ids', (array)$customerGroupIds);
        }
        return $this->_getData('customer_group_ids');
    }

    public function getMatchingProductIds($conditionType)
    {
        if ($conditionType == "where_conditions") {
            return $this->getMatchingProductIdsForWhereConditions();
        } else {
            return $this->getMatchingProductIdsForWhatConditions();
        }
    }

    /**
     * Get array of product ids which are matched by rule
     *
     * @return array
     */
    public function getMatchingProductIdsForWhatConditions()
    {
        if ($this->_matchWhatConditionsProductIds === null) {
            $this->_matchWhatConditionsProductIds = [];
            $this->setCollectedAttributes([]);

            if ($this->getWebsiteIds()) {
                /** @var $productCollection \Magento\Catalog\Model\ResourceModel\Product\Collection */
                $productCollection = $this->_productCollectionFactory->create();
                $productCollection->addWebsiteFilter($this->getWebsiteIds());
                if ($this->_whatConditionsProductsFilter) {
                    $productCollection->addIdFilter($this->_whatConditionsProductsFilter);
                }
                $this->getWhereConditions()->collectValidatedAttributes($productCollection);

                $this->_resourceIterator->walk(
                    $productCollection->getSelect(),
                    [[$this, 'callbackValidateProduct']],
                    [
                        'attributes' => $this->getCollectedAttributes(),
                        'product' => $this->_productFactory->create(),
                        'condition_type' => 'what_conditions'
                    ]
                );
            }
        }

        return $this->_matchWhatConditionsProductIds;
    }
    /**
     * Get array of product ids which are matched by rule
     *
     * @return array
     */
    public function getMatchingProductIdsForWhereConditions()
    {
        if ($this->_matchWhereConditionsProductIds === null) {
            $this->_matchWhereConditionsProductIds = [];
            $this->setCollectedAttributes([]);

            if ($this->getWebsiteIds()) {
                /** @var $productCollection \Magento\Catalog\Model\ResourceModel\Product\Collection */
                $productCollection = $this->_productCollectionFactory->create();
                $productCollection->addWebsiteFilter($this->getWebsiteIds());
                if ($this->_whereConditionsProductsFilter) {
                    $productCollection->addIdFilter($this->_whereConditionsProductsFilter);
                }
                $this->getWhereConditions()->collectValidatedAttributes($productCollection);

                $this->_resourceIterator->walk(
                    $productCollection->getSelect(),
                    [[$this, 'callbackValidateProduct']],
                    [
                        'attributes' => $this->getCollectedAttributes(),
                        'product' => $this->_productFactory->create(),
                        'condition_type' => 'where_conditions'
                    ]
                );
            }
        }

        return $this->_matchWhereConditionsProductIds;
    }
    /**
     * Callback function for product matching
     *
     * @param array $args
     * @return void
     */
    public function callbackValidateProduct($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $key = $args['condition_type'];

        $websites = $this->_getWebsitesMap();
        $results = [];

        foreach ($websites as $websiteId => $defaultStoreId) {
            $product->setStoreId($defaultStoreId);
            if ($key === 'where_conditions') {
                $results[$websiteId] = $this->getWhereConditions()->validate($product);
            } else {
                $results[$websiteId] = $this->getWhatConditions()->validate($product);
            }

        }
        if ($key === 'where_conditions') {
            $this->_matchWhereConditionsProductIds[$product->getId()] = $results;
        } else {
            $this->_matchWhatConditionsProductIds[$product->getId()] = $results;
        }

    }

    /**
     * Prepare website map
     *
     * @return array
     */
    protected function _getWebsitesMap()
    {
        $map = [];
        $websites = $this->_storeManager->getWebsites();
        foreach ($websites as $website) {
            // Continue if website has no store to be able to create catalog rule for website without store
            if ($website->getDefaultStore() === null) {
                continue;
            }
            $map[$website->getId()] = $website->getDefaultStore()->getId();
        }
        return $map;
    }


    public function getProductsFilter($conditionType)
    {
        if ($conditionType == "where_conditions") {
            return $this->getWhereConditionsProductsFilter();
        } else {
            return $this->getWhatConditionsProductsFilter();
        }
    }
    /**
     * Filtering products that must be checked for matching with rule
     *
     * @param  int|array $productIds
     * @return void
     * @codeCoverageIgnore
     */
    public function setWhereConditionsProductsFilter($productIds)
    {
        $this->_whereConditionsProductsFilter = $productIds;
    }

    /**
     * Returns products filter
     *
     * @return array|int|null
     * @codeCoverageIgnore
     */
    public function getWhereConditionsProductsFilter()
    {
        return $this->_whereConditionsProductsFilter;
    }

    /**
     * Filtering products that must be checked for matching with rule
     *
     * @param  int|array $productIds
     * @return void
     * @codeCoverageIgnore
     */
    public function setWhatConditionsProductsFilter($productIds)
    {
        $this->_whatConditionsProductsFilter = $productIds;
    }

    /**
     * Returns products filter
     *
     * @return array|int|null
     * @codeCoverageIgnore
     */
    public function getWhatConditionsProductsFilter()
    {
        return $this->_whatConditionsProductsFilter;
    }

}
