<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Block\Content\Lists;

/**
 * Class Pager
 */
class Pager extends \Magento\Theme\Block\Html\Pager
{
    /**
     * @var \Amasty\Blog\Helper\Settings
     */
    private $settings;

    /**
     * @var null
     */
    private $object = null;

    /**
     * @var null
     */
    private $urlPostfix = null;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Amasty\Blog\Helper\Settings $settings,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->settings = $settings;
    }

    /**
     * @param $object
     * @return $this
     */
    public function setPagerObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return null
     */
    public function getPagerObject()
    {
        return $this->object;
    }

    /**
     * @param string $page
     * @return string
     */
    public function getPageUrl($page)
    {
        return $this->getPagerObject()->getUrl($page) . $this->getUrlPostfix();
    }

    /**
     * @return bool
     */
    public function isOldStyle()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getColorClass()
    {
        return $this->settings->getIconColorClass();
    }

    /**
     * Get Url Postfix
     *
     * @return null
     */
    public function getUrlPostfix()
    {
        return $this->urlPostfix;
    }

    /**
     * Set URL postfix
     *
     * @param $urlPostfix
     *
     * @return $this
     */
    public function setUrlPostfix($urlPostfix)
    {
        $this->urlPostfix = $urlPostfix;

        return $this;
    }

    /**
     * Return current page
     *
     * @return int
     */
    public function getCurrentPage()
    {
        if (is_object($this->_collection)) {
            return $this->_collection->getCurPage();
        }

        $pageNum = (int)$this->getRequest()->getParam($this->getPageVarName());

        return $pageNum ?: 1;
    }
}
