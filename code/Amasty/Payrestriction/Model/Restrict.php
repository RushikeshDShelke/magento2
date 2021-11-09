<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Payrestriction
 */


namespace Amasty\Payrestriction\Model;

class Restrict
{
    /**
     * @var null
     */
    protected $allRules = null;

    /**
     * @var ResourceModel\Rule\Collection
     */
    protected $ruleCollection;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @var \Amasty\CommonRules\Model\Validator\Coupon
     */
    private $couponValidator;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetaData;

    /**
     * Restrict constructor.
     * @param ResourceModel\Rule\Collection $ruleCollection
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        \Amasty\Payrestriction\Model\ResourceModel\Rule\Collection $ruleCollection,
        \Magento\Framework\App\State $appState,
        \Amasty\CommonRules\Model\Validator\Coupon $couponValidator,
        \Magento\Framework\App\ProductMetadataInterface $productMetaData
    ) {
        $this->ruleCollection = $ruleCollection;
        $this->appState = $appState;
        $this->couponValidator = $couponValidator;
        $this->productMetaData = $productMetaData;
    }

    /**
     * @param $paymentMethods
     * @param null $quote
     * @return mixed
     */
    public function restrictMethods($paymentMethods, $quote = null)
    {
        if (!$quote){
            return $paymentMethods;
        }

        if ($this->productMetaData->getVersion() <= '2.2.1') {
            $quote->collectTotals();
        }

        $address = $quote->getShippingAddress();
        $items   = $quote->getAllItems();
        $address->setItemsToValidateRestrictions($items);
        $hasBackOrders = false;
        $hasNoBackOrders = false;

        foreach ($items as $item){
            if ($item->getBackorders() > 0 ){
                $hasBackOrders = true;
            } else {
                $hasNoBackOrders = true;
            }
            if ($hasBackOrders && $hasNoBackOrders) {
                break;
            }
        }

        foreach ($paymentMethods as $k => $method){
            foreach ($this->getRules($address, $items) as $rule){
                if (
                    $rule->restrict($method)
                    && $this->couponValidator->validate($rule, $items, $quote)
                    && !$this->couponValidator->validate($rule, $items, $quote, true)
                    && $rule->validate($address, $items)
                ) {
                    unset($paymentMethods[$k]);
                }
            }
        }

        return $paymentMethods;
    }

    /**
     * @param $address
     * @return $this|null
     */
    public function getRules($address)
    {
        if (is_null($this->allRules)){
            $this->allRules = $this->ruleCollection->addAddressFilter($address);

            if ($this->appState->getAreaCode() == \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE) {
                $this->allRules->addFieldToFilter('for_admin', 1);
            }

            $this->allRules->load();

            foreach ($this->allRules as $rule){
                $rule->afterLoad();
            }
        }

        return $this->allRules;
    }
}
