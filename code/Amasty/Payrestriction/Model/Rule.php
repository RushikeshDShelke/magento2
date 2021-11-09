<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Payrestriction
 */


namespace Amasty\Payrestriction\Model;

class Rule extends \Amasty\CommonRules\Model\Rule
{
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Amasty\CommonRules\Model\Rule\Condition\CombineFactory $conditionCombine,
        \Amasty\CommonRules\Model\Rule\Condition\Product\CombineFactory $conditionProductCombine,
        \Amasty\Base\Model\Serializer $serializer,
        \Amasty\CommonRules\Model\Modifiers\Subtotal $subtotalModifier,
        \Amasty\CommonRules\Model\Validator\Backorder $backorderValidator,
        \Amasty\Payrestriction\Model\ResourceModel\Rule $resource,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $localeDate,
            $storeManager,
            $conditionCombine,
            $conditionProductCombine,
            $serializer,
            $subtotalModifier,
            $backorderValidator,
            $resource,
            $data
        );
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Amasty\Payrestriction\Model\ResourceModel\Rule');
        $this->subtotalModifier->setSectionConfig(\Amasty\Payrestriction\Model\RegistryConstants::SECTION_KEY);
    }

    /**
     * @param $method
     * @return bool
     */
    public function restrict($method)
    {
        return (false !== strpos($this->getMethods(), ',' . $method->getCode() . ','));
    }
}
