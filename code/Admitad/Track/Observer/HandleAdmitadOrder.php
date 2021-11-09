<?php

namespace Admitad\Track\Observer;

use Admitad\Track\Helper\Admitad;
use Admitad\Track\Helper\Data;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\HTTP\Header;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class HandleAdmitadOrder implements ObserverInterface
{

    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ObjectManagerInterface;
     */
    private $objectManager;
    /**
     * @var LoggerInterface;
     */
    private $logger;
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;
    /**
     * @var Header
     */
    private $httpHeader;

    public function __construct(
        RequestInterface $request,
        ObjectManagerInterface $objectManager,
        LoggerInterface $logger,
        Data $helper,
        CookieManagerInterface $cookieManager,
        Header $httpHeader
    ) {
        $this->request = $request;
        $this->objectManager = $objectManager;
        $this->logger = $logger;
        $this->helper = $helper;
        $this->cookieManager = $cookieManager;
        $this->httpHeader = $httpHeader;
    }

    public function execute(
        Observer $observer
    ) {
        $uid = $this->cookieManager->getCookie(Admitad::COOKIE_NAME, false);
        if (!$uid) {
            return $this;
        }

        $campaignCode = $this->helper->getGeneralConfig('admitad_campaign_code');
        $postbackKey = $this->helper->getGeneralConfig('admitad_postback_key');
        $currencyCode = $this->helper->getGeneralConfig('currency_code');

        if (!$campaignCode || !$postbackKey) {
            return $this;
        }

        $event = $observer->getEvent();
        /** @var \Magento\Sales\Model\Order $order */
        $order = $event->getOrder();

        $orderId = $order->getIncrementId();

        $positions = [];
        foreach ($order->getAllVisibleItems() as $item) {
            /** @var \Magento\Sales\Model\Order\Item $item */
            $tariffData = Admitad::getTariffData($item->getProductId());
            if (!$tariffData) {
                continue;
            }

            $product = [
                'product_id' => $item->getProductId(),
                'price'      => $item->getPrice(),
                'quantity'   => $item->getQtyOrdered(),
            ];

            $positions[] = array_merge($product, $tariffData);
        }

        $parameters = [];
        $parameters['action_useragent'] = $this->httpHeader->getHttpUserAgent();
        $parameters['currency_code'] = $currencyCode;
        $parameters['adm_source'] = 'cookie';

        if (!empty($positions)) {
            Admitad::admitadPostback($campaignCode, $postbackKey, $orderId, $positions, $parameters, $uid);
        }

        return $this;
    }
}
