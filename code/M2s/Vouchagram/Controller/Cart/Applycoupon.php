<?php

namespace M2s\Vouchagram\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;


class ApplyCoupon extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $_cartModel;

    public $_objectManager;

    protected $quote;
    
    protected $request;
    protected $checkoutSession;
    protected $catalogSession;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Checkout\Model\Cart $cartModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\Session $catalogSession  
        // \Magento\Quote\Model\Quote $quote,
        // \Magento\Quote\Model\Quote\Address\Total $total
    ) 
    {
        $this->_objectManager = $objectManager;
        $this->_messageManager = $context->getMessageManager();
        $this->_resultPageFactory = $resultPageFactory;
        $this->_cartModel = $cartModel;
        $this->_storeManager = $storeManager;
        $this->_quote = $checkoutSession->getQuote();
        $this->_session = $checkoutSession;  
        $this->request = $request;  
        $this->catalogSession = $catalogSession;
        // $this->_quote = $quote;
        // $this->_total = $total;

        parent::__construct($context);
    }

    public function execute()
    { 

        $resultRedirect = $this->resultRedirectFactory->create();
        $wholeFields = $this->getRequest()->getParams();
        
        if(isset($wholeFields["remove"])){
            $this->catalogSession->unsCouponAmount();
            $couponInfo = $this->_session->getCouponInfo();
            $this->_messageManager->addSuccess(__('Voucher removed successfully'));
            $this->_session->unsCouponInfo();
            $this->_session->getQuote()->collectTotals()->save();
            $coupons = explode(",",$wholeFields['coupon_code']);
            foreach ($coupons as $each) {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/Cancel?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&requestjobnumber='.$this->_session->getQuote()->getId().'&billvalue='.$this->_session->getQuote()->getGrandTotal().'&voucherNumber='.preg_replace('/\s+/', '',$each),
                    CURLOPT_USERAGENT => 'ShopCrocs.in'
                ]);
                $resp = json_decode(curl_exec($curl));

            }

        }else{
            try{
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CONNECTTIMEOUT => 0,
                    CURLOPT_TIMEOUT => 120,
                    CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/BatchConsume?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&requestjobnumber='.$this->_session->getQuote()->getId().'&voucherNumber='.preg_replace('/\s+/', '',$wholeFields['coupon_code']).'&billvalue='.$this->_session->getQuote()->getGrandTotal(),
                    CURLOPT_USERAGENT => 'ShopCrocs.in'
                ]); 
                $resp = json_decode(curl_exec($curl));
                // Send the request & save response to $resp
                // print_r($resp);
                // print_r(curl_errno($curl));
                // die;
                if (curl_errno($curl)) {

                        $coupons = explode(",",$wholeFields['coupon_code']);
                        foreach ($coupons as $each) {
                            $curl = curl_init();
                            curl_setopt_array($curl, [
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/Cancel?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&billvalue='.$this->_session->getQuote()->getGrandTotal().'&requestjobnumber='.$this->_session->getQuote()->getId().'&voucherNumber='.preg_replace('/\s+/', '',$each),
                                CURLOPT_USERAGENT => 'ShopCrocs.in'
                            ]);
                            $resp = json_decode(curl_exec($curl));
                            $this->_messageManager->addError(
                                __(
                                    'Something went wrong. Please try later.'
                                )
                            );
                        }
                        return $resultRedirect->setPath('checkout/cart');
                }
                // echo "<pre>";
                // print_r($resp);
                // die;
                // Close request to clear up some resources
                $response = $resp->vBatchConsumeResult[0];
                curl_close($curl);
                if(!$response->ErrorMsg){
                    // $amountValue = $response->VOUCHERACTION["VALUE"];
                    if($response->ResultType=="SUCCESS"){
                        $total = 0;
                        foreach ($response->VOUCHERACTION as $each) {
                            $total = $total + $each->VALUE;
                        }
                        // echo $total;
                        $couponActualValue = $total;
                        if($total>$this->_session->getQuote()->getGrandTotal()){
                            $amountValue = $this->_session->getQuote()->getGrandTotal();
                            $this->_messageManager->addSuccess(
                                __(
                                    'GV value is '.$this->_objectManager->create('\Magento\Framework\Pricing\PriceCurrencyInterface')->format($total,true,2)
                                    .' which is more than the bill value, so remaining amount('.$this->_objectManager->create('\Magento\Framework\Pricing\PriceCurrencyInterface')->format((-$this->_session->getQuote()->getGrandTotal()),true,2).') will be forfeited.'
                                )
                            );
                        }else{
                            $amountValue = $total;
                            $this->_messageManager->addSuccess(
                                __(
                                    'Voucher redeemed successfully'
                                )
                            );
                        }
                        $cartQuote= $this->_session->getQuote()->getData();
                        $grandTotalFinal = $this->_session->getQuote()->getGrandTotal() - $amountValue;
                        // echo $amountValue;
                        // die;
                        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
                        $logger = new \Zend\Log\Logger();
                        $logger->addWriter($writer);
                        $logger->info('--------------------Couponpost--'.abs($amountValue));
                        if($amountValue):
                            $this->catalogSession->unsCouponAmount();                            
                            $this->catalogSession->setCouponAmount(abs($amountValue));
                            $this->_session->getQuote()->collectTotals()->save();
                        endif;

                        $couponInfo['vouchagram'] = [
                            'coupon_code'=>$wholeFields['coupon_code'],
                            'amount'=>-abs($amountValue),
                            'actual_value'=>abs($couponActualValue)
                        ];
                            
                        $this->_session->setCouponInfo($couponInfo);
                        
                        $coupons = explode(',', $wholeFields['coupon_code']);
                        foreach ($coupons as $value) {
                            $this->_objectManager->create('M2s\Vouchagram\Model\Vouchagram')->setCouponCode(preg_replace('/\s+/', '',$value))->setQuoteId($this->_session->getQuote()->getId())->setQuoteValue($this->_session->getQuote()->getGrandTotal())->save();
                        }
                    }else{
                        $this->_messageManager->addError(
                            __(
                                'Voucher has been already Used'
                            )
                        );
                    }
                }else{
                    //print_r($response->ErrorMsg);
                    $this->_messageManager->addError(
                        __(
                            $response->FailedVoucherNumber?$response->ErrorMsg." (".$response->FailedVoucherNumber.')':$response->ErrorMsg
                        )
                    );
                }  
            } catch(Exception $e){
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://pos.vouchagram.com/Service/RestServiceImpl.svc/Cancel?deviceCode=p&merchantUid=329D1215-57BD-424D-A353-55CEF41E66A2&Password=Snpq5ShO9BJSexjACeUYLA%3D%3D&ShopCode=CROCS&requestjobnumber='.$this->_session->getQuote()->getId().'&billvalue='.$this->_session->getQuote()->getGrandTotal().'&voucherNumber='.$wholeFields['coupon_code'],
                    CURLOPT_USERAGENT => 'ShopCrocs.in'
                ]);
                $resp = json_decode(curl_exec($curl));
                $this->_messageManager->addError(
                    __(
                        'Something went wrong. Please try later.'
                    )
                );
            }
            
            
            
        }
        return $resultRedirect->setPath('checkout/cart');

    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $amount = $quote->getShippingAddress()->getCoupondiscountTotal();
        return [
            'code' => 'coupondiscount_total',
            'title' => $this->getLabel(),
            'value' => $amount
        ];
    }

}
