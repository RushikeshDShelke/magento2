<?php 
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_Popup
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\Popup\Model;

class PopupCookie
{

    /**
     * Cookie Manager
     *
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    private $cookieManager;

    /**
     * Cookie Metadata Factory
     *
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * Session Manager
     *
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    private $sessionManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
     * @param \Magento\Framework\Session\SessionManagerInterface $sessionManager
     */
    public function __construct(
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager
    ) {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Get cookie
     *
     * @param string $cookieName
     * @return string
     */
    public function get($cookieName)
    {
        $content = $this->cookieManager->getCookie($cookieName);
        return $content;
    }

    /**
     * Set cookie
     *
     * @param string $cookieName
     * @param string $value
     * @param int $duration
     * @return void
     */
    public function set($cookieName, $value, $duration)
    {
        $metadata = $this->cookieMetadataFactory
          ->createPublicCookieMetadata()
          ->setDuration($duration)
          ->setPath($this->sessionManager->getCookiePath())
          ->setDomain($this->sessionManager->getCookieDomain());
        try {
            $this->cookieManager->setPublicCookie(
                $cookieName,
                $value,
                $metadata
            );
        } catch (\Exception $e) {
            throw new \Exception("Cookie not found.", 69);
        }
        
    }
}
