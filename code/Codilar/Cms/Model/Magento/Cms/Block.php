<?php

namespace Codilar\Cms\Model\Magento\Cms;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Model\ResourceModel\Block as ResourceCmsBlock;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/*
 *
 */

class Block extends \Magento\Cms\Model\Block
{
    /**
     * Prevent blocks recursion
     *
     * @return AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $needle = 'block_id="' . $this->getId() . '"';

        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }

        if (false == strstr($this->getContent(), $needle)) {
            return parent::beforeSave();
        }
        throw new \Magento\Framework\Exception\LocalizedException(
            __('Make sure that static block content does not reference the block itself.')
        );
    }
	
}
	
	