<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Indexer\Product;


use Yosto\Arp\Model\Indexer\AbstractIndexer;

/**
 * Class ProductRuleIndexer
 * @package Yosto\Arp\Model\Indexer\Product
 */
class ProductRuleIndexer extends AbstractIndexer
{
    /**
     * {@inheritdoc}
     */
    protected function doExecuteList($ids)
    {
        $this->indexBuilder->reindexByIds(array_unique($ids));
        $this->getCacheContext()->registerEntities(
            \Magento\Catalog\Model\Product::CACHE_TAG,
            $ids);
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecuteRow($id)
    {
        $this->indexBuilder->reindexById($id);
    }

}