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
namespace Bss\Popup\Block;

use Bss\Popup\Model\Source\PageDisplay;

class Popup extends \Magento\Framework\View\Element\Template
{
    /**
     * Block Type Page
     *
     * @var int
     */
    protected $blockType;

    /**
     * Store Manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Core Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Popup Helper
     *
     * @var \Bss\Popup\Helper\Data
     */
    protected $helper;

    /**
     * Filter Provider
     *
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;
    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * Popup constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Bss\Popup\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Bss\Popup\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->filterProvider = $filterProvider;
        $this->helper = $helper;
        $this->coreRegistry = $registry;
        $this->storeManager = $context->getStoreManager();
        $this->jsonEncoder = $jsonEncoder;

        parent::__construct($context, $data);
    }

    /**
     * Retrieve block type
     *
     * @return int
     */
    public function getBlockType()
    {
        if (false !== strpos($this->getNameInLayout(), 'popup_product')) {
            $this->blockType = PageDisplay::PRODUCT_PAGE;
        }
        if (false !== strpos($this->getNameInLayout(), 'popup_category')) {
            $this->blockType = PageDisplay::CATEGORY_PAGE;
        }
        if (false !== strpos($this->getNameInLayout(), 'popup_home')) {
            $this->blockType = PageDisplay::HOME_PAGE;
        }
        if (false !== strpos($this->getNameInLayout(), 'popup_cart')) {
            $this->blockType = PageDisplay::CART_PAGE;
        }
        if (false !== strpos($this->getNameInLayout(), 'popup_checkout')) {
            $this->blockType = PageDisplay::CHECKOUT_PAGE;
        }
        if (false !== strpos($this->getNameInLayout(), 'popup_default')) {
            $this->blockType = PageDisplay::ALL_OTHER_PAGE;
        }
        return $this->blockType;
    }

    /**
     * Get Store Id
     *
     * @return int
     */
    public function getStoreId()
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $storeId;
    }

    /**
     * Get Product Id
     *
     * @return int
     */
    public function getProductId()
    {
        $product = $this->coreRegistry->registry('product');
        $productId = (!empty($product))? $product->getId() : 0;
        return $productId;
    }

    /**
     * Get Category Id
     *
     * @return int
     */
    public function getCategoryId()
    {
        $category = $this->coreRegistry->registry('current_category');
        $categoryId = (!empty($category))? $category->getId() : 0;
        return $categoryId;
    }

    /**
     * Get Page Information
     *
     * @return array
     */
    public function getPageInformation()
    {
        $pageInformation = [];
        $request = $this->getRequest();
        $pageInformation['routeName'] = $request->getRouteName();
        $pageInformation['moduleName'] = $request->getModuleName();
        $pageInformation['controllerName'] = $request->getControllerName();
        $pageInformation['actionName'] = $request->getActionName();
        $pageInformation['uri'] = $request->getRequestUri();
        return $this->jsonEncoder->encode($pageInformation);
    }

    /**
     * Get Helper
     *
     * @return \Bss\Popup\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Filter Content
     *
     * @param string $stringContent
     * @return string
     */
    public function filterContent($stringContent)
    {
        return $this->filterProvider->getPageFilter()->filter($stringContent);
    }

}
