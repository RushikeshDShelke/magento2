<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Plugin\Indexer\Product;

use Magento\Rule\Model\Condition\Combine;
use Yosto\Arp\Model\Indexer\Rule\RuleProductProcessor;
use Yosto\Arp\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Yosto\Arp\Model\Rule;
use Yosto\Arp\Model\Rule\Condition\WhereCombine;
use Yosto\Arp\Model\Rule\Condition\WhatCombine;
use Magento\Framework\Message\ManagerInterface;
use Magento\Rule\Model\Condition\Product\AbstractProduct;

/**
 * Class Attribute
 * @package Yosto\Arp\Plugin\Indexer\Product
 */
class Attribute
{
    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var RuleProductProcessor
     */
    protected $ruleProductProcessor;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param RuleProductProcessor $ruleProductProcessor
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        RuleCollectionFactory $ruleCollectionFactory,
        RuleProductProcessor $ruleProductProcessor,
        ManagerInterface $messageManager
    ) {
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->ruleProductProcessor = $ruleProductProcessor;
        $this->messageManager = $messageManager;
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $subject
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
     * @return \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $subject,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
    ) {
        if ($attribute->dataHasChangedFor('is_used_for_promo_rules') && !$attribute->getIsUsedForPromoRules()) {
            $this->checkCatalogRulesAvailability($attribute->getAttributeCode());
        }
        return $attribute;
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $subject
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
     * @return \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterDelete(
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $subject,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
    ) {
        if ($attribute->getIsUsedForPromoRules()) {
            $this->checkCatalogRulesAvailability($attribute->getAttributeCode(), $conditionType);
        }
        return $attribute;
    }

    protected function checkArpRulesAvailability($attributeCode, $conditionType)
    {
        /* @var $collection RuleCollectionFactory */
        if ($conditionType == "where_conditions") {
            $collection = $this->ruleCollectionFactory->create()->addAttributeInWhereConditionFilter($attributeCode);

            $disabledRulesCount = 0;
            foreach ($collection as $rule) {
                /* @var $rule Rule */
                $rule->setIsActive(0);
                /* @var $rule->getWhereConditions() Combine */
                $this->removeAttributeFromConditions($rule->getWhereConditions(), $attributeCode);
                $rule->save();

                $disabledRulesCount++;
            }

            if ($disabledRulesCount) {
                $this->ruleProductProcessor->markIndexerAsInvalid();
                $this->messageManager->addWarning(
                    __(
                        'You disabled %1 arp rules based on "%2" attribute.',
                        $disabledRulesCount,
                        $attributeCode
                    )
                );
            }
        } else {
            $collection = $this->ruleCollectionFactory->create()->addAttributeInWhatConditionFilter($attributeCode);

            $disabledRulesCount = 0;
            foreach ($collection as $rule) {
                /* @var $rule Rule */
                $rule->setIsActive(0);
                /* @var $rule->getWhatConditions() Combine */
                $this->removeAttributeFromConditions($rule->getWhatConditions(), $attributeCode);
                $rule->save();

                $disabledRulesCount++;
            }

            if ($disabledRulesCount) {
                $this->ruleProductProcessor->markIndexerAsInvalid();
                $this->messageManager->addWarning(
                    __(
                        'You disabled %1 arp rules based on "%2" attribute.',
                        $disabledRulesCount,
                        $attributeCode
                    )
                );
            }
        }


        return $this;
    }

    /**
     * Check rules that contains affected attribute
     * If rules were found they will be set to inactive and notice will be add to admin session
     *
     * @param string $attributeCode
     * @return $this
     */
    protected function checkCatalogRulesAvailability($attributeCode)
    {
        $this->checkArpRulesAvailability($attributeCode, "where_conditions");
        $this->checkArpRulesAvailability($attributeCode, "what_conditions");
    }

    /**
     * Remove catalog attribute condition by attribute code from rule conditions
     *
     * @param Combine $combine
     * @param string $attributeCode
     * @return void
     */
    protected function removeAttributeFromConditions(Combine $combine, $attributeCode)
    {
        $conditions = $combine->getConditions();
        foreach ($conditions as $conditionId => $condition) {
            if ($condition instanceof Combine) {
                $this->removeAttributeFromConditions($condition, $attributeCode);
            }
            if ($condition instanceof AbstractProduct) {
                if ($condition->getAttribute() == $attributeCode) {
                    unset($conditions[$conditionId]);
                }
            }
        }
        $combine->setConditions($conditions);
    }

}
