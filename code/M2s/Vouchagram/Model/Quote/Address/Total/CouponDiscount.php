<?php

namespace M2s\Vouchagram\Model\Quote\Address\Total;

class CouponDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    protected $_priceCurrency;


    protected $_checkoutSession;


    protected $catalogSession;


    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Model\Session $catalogSession
    ) {
        $this->_priceCurrency = $priceCurrency;
        $this->_checkoutSession = $checkoutSession;
        $this->catalogSession = $catalogSession;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        // $TotalAmount = $total->getSubtotal();

        // $discountAmount ="-".$TotalAmount; 
        // $total->setCustomDiscountAmount($discountAmount);
        // $total->setBaseDiscountAmount($discountAmount);
        // $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
        // $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);
        // $quote->getShippingAddress()->setCoupondiscountTotal($TotalAmount);
        // $quote->setCoupondiscountTotal($TotalAmount);
        // $total->addTotalAmount($this->getCode(), $discountAmount);
        // $total->addBaseTotalAmount($this->getCode(), $discountAmount);
        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        // $logger = new \Zend\Log\Logger();
        // $logger->addWriter($writer);
        // $logger->info('--------------------out--');

        $couponInfo = $this->_checkoutSession->getCouponInfo();
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('--------------------coupon--'.$this->catalogSession->getCouponAmount());
        $logger->info('--------------------subTotal--'.$total->getSubtotal());
        $logger->info('--------------------MagentoDiscount--'.$total->getDiscountAmount());
        // $logger->info('--------------------Total--'.$total->getBaseGrandTotal());

        $couponAmount = 0;

        $discountCouponAmount = 0;

        $couponInfo = $this->_checkoutSession->getCouponInfo();

        if ($couponInfo) {
            if(($total->getSubtotal()+$total->getDiscountAmount())>$couponInfo['vouchagram']['actual_value']) {
                $couponAmount = $couponInfo['vouchagram']['actual_value'];
            }else{
                $couponAmount = $total->getSubtotal()+$total->getDiscountAmount();
            }
            if($couponAmount):

                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
                $logger = new \Zend\Log\Logger();
                $logger->addWriter($writer);
                $logger->info('--------------------11--'.$couponAmount);


                $discountAmount ="-".$couponAmount; 
                $total->setCustomDiscountAmount($discountAmount);
                $total->setBaseDiscountAmount($discountAmount);
                // $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
                // $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);
                $quote->getShippingAddress()->setCoupondiscountTotal($couponAmount);
                $quote->setCoupondiscountTotal($couponAmount);
                $total->addTotalAmount($this->getCode(), $discountAmount);
                $total->addBaseTotalAmount($this->getCode(), $discountAmount);
                
            else:
                // $total->setCustomDiscountAmount($discountCouponAmount);
                // $total->setBaseDiscountAmount($discountCouponAmount);
                // $total->setSubtotalWithDiscount($total->getSubtotal() + $discountCouponAmount);
                // $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountCouponAmount);
                // $quote->getShippingAddress()->setCoupondiscountTotal($discountCouponAmount);
                // $quote->setCoupondiscountTotal($discountCouponAmount);
                // $total->addTotalAmount($this->getCode(), $discountCouponAmount);
                // $total->addBaseTotalAmount($this->getCode(), $discountCouponAmount);
                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('--------------------12--'.$couponAmount);
            endif;
        }else{
            $couponAmount = $this->catalogSession->getCouponAmount();
            if($couponAmount){
                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
                if(($total->getSubtotal()+$total->getDiscountAmount())>$couponAmount){
                    $couponAmount = $couponAmount;
                }else{
                    $couponAmount = ($total->getSubtotal()+$total->getDiscountAmount());
                }
                $discountAmount ="-".$couponAmount; 
                $total->setCustomDiscountAmount($discountAmount);
                $total->setBaseDiscountAmount($discountAmount);
                $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
                $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);
                $quote->getShippingAddress()->setCoupondiscountTotal($couponAmount);
                $quote->setCoupondiscountTotal($couponAmount);
                $total->addTotalAmount($this->getCode(), $discountAmount);
                $total->addBaseTotalAmount($this->getCode(), $discountAmount);
            }else{
                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('--------------------22--'.$quote->getBaseGrandTotal());
                // $total->setCustomDiscountAmount($discountCouponAmount);
                // $total->setBaseDiscountAmount($discountCouponAmount);
                // $total->setSubtotalWithDiscount($total->getSubtotal() + $discountCouponAmount);
                // $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountCouponAmount);
                // $quote->getShippingAddress()->setCoupondiscountTotal($discountCouponAmount);
                // $quote->setCoupondiscountTotal($discountCouponAmount);
                // $total->addTotalAmount($this->getCode(), $discountCouponAmount);
                // $total->addBaseTotalAmount($this->getCode(), $discountCouponAmount);
            }
        }


        return $this;
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $couponInfo = $this->_checkoutSession->getCouponInfo();

        if ($couponInfo) {
            if(($total->getSubtotal()+$total->getDiscountAmount())>$couponInfo['vouchagram']['actual_value']) {
                $couponAmount = $couponInfo['vouchagram']['actual_value'];
            }else{
                $couponAmount = $total->getSubtotal()+$total->getDiscountAmount();
            }
        }   else{
            $couponAmount = $this->catalogSession->getCouponAmount();
            if(($total->getSubtotal()+$total->getDiscountAmount())>$couponAmount){
                $couponAmount = $couponAmount;
            }else{
                $couponAmount = ($total->getSubtotal()+$total->getDiscountAmount());
            }
        }

        return [
            'code' => 'coupondiscount_total',
            'title' => $this->getLabel(),
            'value' => "-".$couponAmount
        ];
    }

    /**
     * get label
     * @return string
     */
    public function getLabel()
    {
        return __('GyFTR Voucher');
    }
}
