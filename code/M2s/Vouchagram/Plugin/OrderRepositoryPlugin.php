<?php

namespace M2s\Vouchagram\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderRepositoryPlugin
 */
class OrderRepositoryPlugin
{
    /**
     * Order coupon discount code field name
     */
    const COUPONDISCOUNT_CODE = 'coupondiscount_code';
    /**
     * Order coupon discount total field name
     */
    const COUPONDISCOUNT_TOTAL = 'coupondiscount_total';

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Add "coupondiscount_code" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $coupondiscountCode = $order->getData(self::COUPONDISCOUNT_CODE);
        $coupondiscountTotal = $order->getData(self::COUPONDISCOUNT_TOTAL);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setCoupondiscountCode($coupondiscountCode);
        $extensionAttributes->setCoupondiscountTotal($coupondiscountTotal);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * Add "coupondiscount_code" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            $coupondiscountCode = $order->getData(self::COUPONDISCOUNT_CODE);
            $coupondiscountTotal = $order->getData(self::COUPONDISCOUNT_TOTAL);
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setCoupondiscountCode($coupondiscountCode);
            $extensionAttributes->setCoupondiscountTotal($coupondiscountTotal);
            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}