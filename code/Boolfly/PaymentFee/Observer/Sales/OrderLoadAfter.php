<?php
namespace Boolfly\PaymentFee\Observer\Sales;
use Magento\Framework\Event\ObserverInterface;
class OrderLoadAfter implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->getOrderExtensionDependency();
        }
        $attr = $order->getData('fee_amount');
        $extensionAttributes->setFeeAmount($attr);
        $attr1 = $order->getData('base_fee_amount');
        $extensionAttributes->setBaseFeeAmount($attr1);
        $order->setExtensionAttributes($extensionAttributes);
	$order->setBaseFeeAmount(23);
    }

    /**
     * @return mixed
     */
    private function getOrderExtensionDependency()
    {
        $orderExtension = \Magento\Framework\App\ObjectManager::getInstance()->get(
            '\Magento\Sales\Api\Data\OrderExtension'
        );
        return $orderExtension;
    }
}
