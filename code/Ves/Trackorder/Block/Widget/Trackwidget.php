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

namespace Ves\Trackorder\Block\Widget;

use Ves\Trackorder\Block\Trackorder;

class Trackwidget extends Trackorder implements \Magento\Widget\Block\BlockInterface
{

	/**
	 * @var \Ves\Trackorder\Helper\Data
	 */
	protected $_helper;

    /**
     * @var Url
     */
    protected $customerUrl;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context        
     * @param \Magento\Cms\Model\Block                         $blockModel     
     * @param \Ves\Trackorder\Helper\Data                      $dataHelper     
     * @param \Magento\Framework\Registry                      $registry       
     * @param \Magento\Framework\Locale\ResolverInterface      $localeResolver 
     * @param \Magento\Customer\Model\Url                      $customerUrl    
     * @param array                                            $data           
     */
    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Cms\Model\Block $blockModel,
    	\Ves\Trackorder\Helper\Data $dataHelper,
    	\Magento\Framework\Registry $registry,
    	\Magento\Framework\Locale\ResolverInterface $localeResolver,
    	\Magento\Customer\Model\Url $customerUrl,
    	array $data = []
    	) {
    	parent::__construct($context, $blockModel, $dataHelper, $registry, $localeResolver, $customerUrl);
    	$this->customerUrl = $customerUrl;
    	$this->_helper = $dataHelper;
    	$this->setTemplate("widget/link.phtml");
    }

    public function _toHtml()
    {   
        $enable = $this->_helper->getConfig('trackorder_general/enabled');
    	$show_widget = $this->_helper->getConfig("trackorder_general/show_widget");
		if(!$show_widget || !$enable) return;
    	return parent::_toHtml();
    }
}