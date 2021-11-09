<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Helper;

/**
 * Class ConditionConverter
 * @package Yosto\Arp\Helper
 */
class ConditionConverter
{


    /**
     * @var \Magento\CatalogRule\Api\Data\ConditionInterfaceFactory
     */
    protected $ruleConditionFactory;

    /**
     * @param \Magento\CatalogRule\Api\Data\ConditionInterfaceFactory $ruleConditionFactory
     */
    public function __construct(\Magento\CatalogRule\Api\Data\ConditionInterfaceFactory $ruleConditionFactory)
    {
        $this->ruleConditionFactory = $ruleConditionFactory;
    }

    /**
     * @param \Magento\CatalogRule\Api\Data\ConditionInterface $dataModel
     * @return array
     */
    public function dataModelToArray(\Magento\CatalogRule\Api\Data\ConditionInterface $dataModel)
    {
        $conditionArray = [
            'type' => $dataModel->getType(),
            'attribute' => $dataModel->getAttribute(),
            'operator' => $dataModel->getOperator(),
            'value' => $dataModel->getValue(),
            'is_value_processed' => $dataModel->getIsValueParsed(),
            'aggregator' => $dataModel->getAggregator()
        ];

        foreach ((array)$dataModel->getConditions() as $condition) {
            $conditionArray['conditions'][] = $this->dataModelToArray($condition);
        }

        return $conditionArray;
    }

    /**
     * @param array $conditionArray
     * @param $key
     * @return \Magento\CatalogRule\Api\Data\ConditionInterface
     */
    public function arrayToDataModel(array $conditionArray, $key)
    {
        /** @var \Magento\CatalogRule\Api\Data\ConditionInterface $ruleCondition */
        $ruleCondition = $this->ruleConditionFactory->create();

        $ruleCondition->setType($conditionArray['type']);
        $ruleCondition->setAggregator(isset($conditionArray['aggregator']) ? $conditionArray['aggregator'] : false);
        $ruleCondition->setAttribute(isset($conditionArray['attribute']) ? $conditionArray['attribute'] : false);
        $ruleCondition->setOperator(isset($conditionArray['operator']) ? $conditionArray['operator'] : false);
        $ruleCondition->setValue(isset($conditionArray['value']) ? $conditionArray['value'] : false);
        $ruleCondition->setIsValueParsed(
            isset($conditionArray['is_value_parsed']) ? $conditionArray['is_value_parsed'] : false
        );

        if ($key == 'what_conditions') {
            if (isset($conditionArray['what_conditions']) && is_array($conditionArray['what_conditions'])) {
                $conditions = [];
                foreach ($conditionArray['what_conditions'] as $condition) {
                    $conditions[] = $this->arrayToDataModel($condition, $key);
                }
                $ruleCondition->setConditions($conditions);
            }
        } else {
            if (isset($conditionArray['where_conditions']) && is_array($conditionArray['where_conditions'])) {
                $conditions = [];
                foreach ($conditionArray['where_conditions'] as $condition) {
                    $conditions[] = $this->arrayToDataModel($condition, $key);
                }
                $ruleCondition->setConditions($conditions);
            }
        }
        return $ruleCondition;
    }

}