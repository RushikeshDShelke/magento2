<?php
/**
 * Venustheme
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Venustheme.com license that is
 * available through the world-wide-web at this URL:
 * http://www.venustheme.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Venustheme
 * @package    Ves_Trackorder
 * @copyright  Copyright (c) 2014 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

namespace Ves\Trackorder\Helper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Url;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
     * Group Collection
     */
    protected $_groupCollection;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * BaseWidget config node per website
     *
     * @var array
     */
    protected $_config = [];

    /**
     * Template filter factory
     *
     * @var \Magento\Catalog\Model\Template\Filter\Factory
     */
    protected $_templateFilterFactory;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

     /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
     protected $_coreRegistry;

     /** @var UrlBuilder */
     protected $actionUrlBuilder;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
     /**
     * @var \Ves\Trackorder\Helper\Trackcode
     */
    protected $_trackcode;

    /**
     * @param \Magento\Framework\App\Helper\Context      $context          
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager     
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider   
     * @param \Magento\Framework\ObjectManagerInterface  $objectManager    
     * @param \Magento\Framework\Registry                $registry         
     * @param Url                                        $actionUrlBuilder 
     * @param \Ves\Trackorder\Helper\Trackcode           $trackcode
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        Url $actionUrlBuilder,
        \Ves\Trackorder\Helper\Trackcode $trackcode
        ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_filterProvider = $filterProvider;
        $this->_coreRegistry = $registry;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->_objectManager = $objectManager;
        $this->_trackcode = $trackcode;

        $chunks = $this->getConfig("trackorder_general/chunks",1);
        $letters = $this->getConfig("trackorder_general/letters",9);
        $separate_text = $this->getConfig("trackorder_general/separate_text","-");

        $this->_trackcode->numberChunks = (int)$chunks;
        $this->_trackcode->numberLettersPerChunk = (int)$letters;
        $this->_trackcode->separateChunkText = (int)$separate_text;
    }

	 /**
     * Return brand config value by key and store
     *
     * @param string $key
     * @param \Magento\Store\Model\Store|int|string $store
     * @return string|null
     */
     public function getConfig($key, $default="", $group = "vestrackorder", $store = null)
     {
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            $group.'/'.$key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        if($result == "") {
            $result = $default;
        }
        return $result;
    }

    public function filter($str)
    {
    	$html = $this->_filterProvider->getPageFilter()->filter($str);
    	return $html;
    }

    public function getTrackorderUrl()
    {
        return $this->actionUrlBuilder->getDirectUrl( "trackorder/index/index" );
    }

    public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getMediaUrl(){
        $storeMediaUrl = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')
        ->getStore()
        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $storeMediaUrl;
    }

    public function generateTrackcode(){
        $serial_number = $this->_trackcode->generate();
        return $serial_number;
    }
}