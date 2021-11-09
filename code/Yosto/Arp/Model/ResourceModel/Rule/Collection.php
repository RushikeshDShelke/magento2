<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\ResourceModel\Rule;
/**
 * Class Collection
 * @package Yosto\Arp\Model\ResourceModel\Rule
 */
class Collection extends \Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Yosto\Arp\Model\Rule',
            'Yosto\Arp\Model\ResourceModel\Rule'
        );
    }

    /**
     * Find product attribute in conditions or actions
     *
     * @param string $attributeCode
     * @return $this
     * @api
     */
    public function addAttributeInWhereConditionFilter($attributeCode)
    {
        $match = sprintf('%%%s%%', substr(serialize(['attribute' => $attributeCode]), 5, -1));
        $this->addFieldToFilter('where_conditions_serialized', ['like' => $match]);

        return $this;
    }

    public function addAttributeInWhatConditionFilter($attributeCode)
    {
        $match = sprintf('%%%s%%', substr(serialize(['attribute' => $attributeCode]), 5, -1));
        $this->addFieldToFilter('what_conditions_serialized', ['like' => $match]);

        return $this;
    }

    public function filterByCustomerGroupIdWebsiteIdBlockPosition(
        $websiteId,
        $customerGroupId,
        $blockPosition
    ) {
        $ruleWebsiteTable = $this->getTable('yosto_arp_rule_website');
        $ruleCustomerGroupTable = $this->getTable('yosto_arp_rule_customer_group');
        $this->getSelect()
            ->join(
                $ruleWebsiteTable . ' as rwt',
                "main_table.rule_id = rwt.rule_id"
            )
            ->join(
                $ruleCustomerGroupTable . ' as rcg',
                "main_table.rule_id = rcg.rule_id"
            )
            ->where("rwt.website_id = {$websiteId} ")
            ->where("rcg.customer_group_id = {$customerGroupId}")
            ->where("main_table.block_position = {$blockPosition}");
        return $this;
    }

}
