<?php

namespace Admitad\Track\Observer;

use Admitad\Track\Helper\Admitad;
use Admitad\Track\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Registry;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Session\SessionManagerInterface;

class HandleAdmitadUid implements ObserverInterface
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var Http
     */
    private $request;
    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;
    /**
     * @var CookieMetadataFactory
     */
    private $cookieMetadataFactory;
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;
    /**
     * @var Data
     */
    private $helper;

    public function __construct(
        Registry $registry,
        Http $request,
        CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory,
        SessionManagerInterface $sessionManager,
        Data $helper
    ) {
        $this->registry = $registry;
        $this->request = $request;
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionManager = $sessionManager;
        $this->helper = $helper;
    }

    public function execute(
        Observer $observer
    ) {
        $paramName = $this->helper->getGeneralConfig('param_name');
        $lifeTime = 90 * 60 * 60 * 24;
        $affiliateId = $this->request->getParam($paramName, false);

        if ($affiliateId) {
            $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
                ->setDuration($lifeTime)
                ->setPath($this->sessionManager->getCookiePath())
                ->setDomain($this->sessionManager->getCookieDomain())
                ->setHttpOnly(false);

            $this->cookieManager->setPublicCookie(
                Admitad::COOKIE_NAME,
                $affiliateId,
                $publicCookieMetadata
            );
        }

        return $this;
    }
}
