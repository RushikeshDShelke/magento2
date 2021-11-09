<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Block\Sidebar;

use Amasty\Blog\Helper\Settings;
use Magento\Widget\Block\BlockInterface;

/**
 * Class
 */
class AbstractClass extends \Amasty\Blog\Block\Layout\AbstractClass implements BlockInterface
{
    /**
     * @var Settings
     */
    private $settingsHelper;

    /**
     * @var \Amasty\Blog\Helper\Date
     */
    private $dateHelper;

    /**
     * @var \Amasty\Blog\Helper\Data
     */
    private $dataHelper;

    /**
     * @var null
     */
    private $ampTemplate = null;

    /**
     * Route to get configuration
     *
     * @var string
     */
    private $route = 'abstract';

    /**
     * Place to define displaying
     *
     * @var string
     */
    private $place;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Amasty\Blog\Helper\Settings $settingsHelper,
        \Amasty\Blog\Helper\Date $dateHelper,
        \Amasty\Blog\Helper\Data $dataHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->settingsHelper = $settingsHelper;
        $this->dateHelper = $dateHelper;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return \Amasty\Blog\Block\Layout\AbstractClass
     */
    public function setAmpTemplate()
    {
        return parent::setTemplate($this->ampTemplate);
    }

    /**
     * @param string
     */
    public function addAmpTemplate($template)
    {
        $this->ampTemplate = $template;
    }

    /**
     * Wrapper for standard strip_tags() function with extra functionality for html entities
     *
     * @param string $data
     * @param string $allowableTags
     * @param bool $allowHtmlEntities
     *
     * @return string
     */
    public function stripTags($data, $allowableTags = null, $allowHtmlEntities = false)
    {
        return $this->dataHelper->stripTags($data, $allowableTags, $allowHtmlEntities);
    }

    /**
     * @param $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return bool
     */
    public function getDisplay()
    {
        $confPlace = $this->settingsHelper->getConfPlace($this->route);

        return $this->place === null || ($confPlace && ($this->place == $confPlace));
    }

    /**
     * @param $collection
     * @return $this
     */
    protected function checkCategory($collection)
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getColorClass()
    {
        return $this->settingsHelper->getIconColorClass();
    }

    /**
     * HTML to text without new lines
     *
     * @param string $content
     *
     * @return string
     */
    private function htmlToPlainText($content)
    {
        $content = $this->sanitize($content);
        $content = str_replace(["\n", "\r"], ' ', $content);

        return $content;
    }

    /**
     * @param $string
     *
     * @return string
     */
    private function sanitize($string)
    {
        $string = str_replace("</p>", "</p> ", $string);
        $string = strip_tags($string);
        $string = htmlspecialchars_decode($string);
        $string = urldecode($string);
        $string = trim($string);

        return $string;
    }

    /**
     * @param $content
     * @return string
     */
    public function getStrippedContent($content)
    {
        $limit = $this->settingsHelper->getRecentPostsShortLimit();
        $content = $this->htmlToPlainText($content);

        if (mb_strlen($content) > $limit) {
            $content = mb_substr($content, 0, $limit);
            if (mb_strpos($content, " ") !== false) {
                $cuts = explode(" ", $content);
                if (!empty($cuts) && count($cuts) > 1) {
                    unset($cuts[count($cuts) - 1]);
                    $content = implode(" ", $cuts);
                }
            }

            $content .= "...";
        }

        return $content;
    }

    /**
     * Prepare widget collection
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection
     */
    public function preparePostCollection($collection)
    {
        if ($this->hasData('amasty_widget_categories')) {
            $widgetCategories = $this->getData('amasty_widget_categories');
            if ($widgetCategories) {
                $widgetCategories = explode(',', $widgetCategories);
                $collection->addCategoryFilter($widgetCategories);
            }
        }

        if ($this->hasData('amasty_widget_tags')) {
            $widgetTags = $this->getData('amasty_widget_tags');
            if ($widgetTags) {
                $widgetTags = explode(',', $widgetTags);
                $collection->addTagFilter($widgetTags);
            }
        }
    }

    /**
     * @return string
     */
    public function getMainBlockStyles()
    {
        return $this->getData('wrap_block') ? '' : 'clear:both;';
    }

    /**
     * @param $datetime
     * @return \Magento\Framework\Phrase|string
     */
    public function renderDate($datetime)
    {
        return $this->hasData('date_manner')
            ? $this->dateHelper->renderDate($datetime, false, $this->getData('date_manner'))
            : $this->dateHelper->renderDate($datetime);
    }

    /**
     * @return Settings
     */
    public function getSettingsHelper()
    {
        return $this->settingsHelper;
    }
}
