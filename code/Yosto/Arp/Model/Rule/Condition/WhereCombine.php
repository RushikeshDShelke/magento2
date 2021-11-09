<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Condition;

/**
 * Class WhereCombine
 * @package Yosto\Arp\Model\Rule\Condition
 */
class WhereCombine extends \Magento\Rule\Model\Condition\Combine
{
    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * Combine constructor.
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param ProductFactory $conditionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Yosto\Arp\Model\Rule\Condition\ProductFactory $conditionFactory,
        array $data = []
    ) {
        $this->_productFactory = $conditionFactory;
        parent::__construct($context, $data);
        $this->setType('Yosto\Arp\Model\Rule\Condition\WhereCombine')
            ->setWhereConditions(
                 []
             );
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $productAttributes = $this->_productFactory->create()->loadAttributeOptions()->getAttributeOption();
        $attributes = [];
        foreach ($productAttributes as $code => $label) {
            $attributes[] = [
                'value' => 'Yosto\Arp\Model\Rule\Condition\Product|' . $code,
                'label' => $label,
            ];
        }
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions,
            [
                [
                    'value' => 'Yosto\Arp\Model\Rule\Condition\WhereCombine',
                    'label' => __('Conditions Combination'),
                ],
                ['label' => __('Product Attribute'), 'value' => $attributes]
            ]
        );
        return $conditions;
    }

    /**
     * @param array $productCollection
     * @return $this
     */
    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            /** @var Product|WhereCombine $condition */
            $condition->collectValidatedAttributes($productCollection);
        }
        return $this;
    }
}