<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Plugin\XmlSitemap\Model;

use Amasty\XmlSitemap\Model\Sitemap as AmastySitemap;

/**
 * Class Sitemap
 */
class Sitemap
{
    /**
     * @var \Amasty\Blog\Model\SitemapFactory
     */
    private $sitemapFactory;

    public function __construct(
        \Amasty\Blog\Model\SitemapFactory $sitemapFactory
    ) {
        $this->sitemapFactory = $sitemapFactory;
    }

    /**
     * @param AmastySitemap $subgect
     * @param \Closure $proceed
     * @param $storeId
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundGetBlogProLinks(AmastySitemap $subgect, \Closure $proceed, $storeId)
    {
        /** @var \Amasty\Blog\Model\Sitemap $blogSitemap */
        $blogSitemap = $this->sitemapFactory->create();
        $blogLinks = $blogSitemap->generateLinks($storeId);

        return $blogLinks;
    }
}
