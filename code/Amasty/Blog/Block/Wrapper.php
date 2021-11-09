<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Wrapper
 */
class Wrapper extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return string
     */
    public function getCanonicalUrl()
    {
        $query = $this->getRequest()->getQuery()->toArray();
        unset($query['amp']);

        if ($query) {
            $result = [
                '_current' => true,
                '_use_rewrite' => true,
                '_query' => $query
            ];
        } else {
            $result = ['_use_rewrite' => true];
        }

        return $this->getUrl('*/*/*', $result);
    }

    /**
     * @return string
     */
    public function getAmpLink()
    {
        return $this->getBaseUrl() . 'amp' . $this->getRequest()->getPathInfo();
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->pageConfig->getDescription();
    }
}
