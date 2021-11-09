<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Api\Data;
/**
 * Interface RuleInterface
 * @package Yosto\Arp\Api\Data
 */
interface RuleInterface
{

    const WHERE_CONDITIONS_SERIALIZED = 'where_conditions_serialized';
    const RULE_ID = 'rule_id';
    const IS_ACTIVE = 'is_active';
    const LAYOUT = 'layout';
    const MAX_PRODUCTS = 'max_products';
    const BLOCK_TITLE = 'block_title';
    const SORT_BY = 'sort_by';
    const SORT_ORDER = 'sort_order';
    const BLOCK_POSITION = 'block_position';
    const NAME = 'name';
    const WHAT_CONDITIONS_SERIALIZED = 'what_conditions_serialized';


    /**
     * Get rule_id
     * @return string|null
     */
    
    public function getRuleId();

    /**
     * Set rule_id
     * @param string $rule_id
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setRuleId($ruleId);

    /**
     * Get is_active
     * @return string|null
     */
    
    public function getIsActive();

    /**
     * Set is_active
     * @param string $is_active
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setIsActive($is_active);

    /**
     * Get block_position
     * @return string|null
     */
    
    public function getBlockPosition();

    /**
     * Set block_position
     * @param string $block_position
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setBlockPosition($block_position);

    /**
     * Get name
     * @return string|null
     */
    
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setName($name);

    /**
     * Get where_conditions_serialized
     * @return \Magento\CatalogRule\Api\Data\ConditionInterface|null
     */
    
    public function getRuleWhereConditions();

    /**
     * Set where_conditions_serialized
     * @param \Magento\CatalogRule\Api\Data\ConditionInterface $condition
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setRuleWhereConditions($condition);

    /**
     * Get what_conditions_serialized
     * @return \Magento\CatalogRule\Api\Data\ConditionInterface|null
     */
    
    public function getRuleWhatConditions();

    /**
     * Set what_conditions_serialized
     * @param \Magento\CatalogRule\Api\Data\ConditionInterface $condition
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setRuleWhatConditions($condition);

    /**
     * Get sort order
     * @return string|null
     */
    
    public function getSortOrder();

    /**
     * Set sort order
     * @param string $sortOrder
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setSortOrder($sortOrder);

    /**
     * Get block_title
     * @return string|null
     */
    
    public function getBlockTitle();

    /**
     * Set block_title
     * @param string $block_title
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setBlockTitle($block_title);

    /**
     * Get layout
     * @return string|null
     */
    
    public function getLayout();

    /**
     * Set layout
     * @param string $layout
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setLayout($layout);

    /**
     * Get max_products
     * @return string|null
     */
    
    public function getMaxProducts();

    /**
     * Set max_products
     * @param string $max_products
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setMaxProducts($max_products);

    /**
     * Get sort_by
     * @return string|null
     */
    
    public function getSortBy();

    /**
     * Set sort_by
     * @param string $sort_by
     * @return \Yosto\Arp\Api\Data\RuleInterface
     */
    
    public function setSortBy($sort_by);
}
