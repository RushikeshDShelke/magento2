<?php

namespace M2s\Vouchagram\Model\Order\Invoice\Total;

class CouponDiscount extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * Collect invoice subtotal
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $order=$invoice->getOrder();
        $orderCoupondiscountTotal = $order->getCoupondiscountTotal();
        if ($orderCoupondiscountTotal&&count($order->getInvoiceCollection())==0) {
            $invoice->setGrandTotal($invoice->getGrandTotal()-$orderCoupondiscountTotal);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal()-$orderCoupondiscountTotal);
        }
        return $this;
    }
}
