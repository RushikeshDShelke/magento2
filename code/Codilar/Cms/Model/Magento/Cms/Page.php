<?php

namespace Codilar\Cms\Model\Magento\Cms;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Page extends \Magento\Cms\Model\Page
{

    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function beforeSave()
    {
        $originalIdentifier = $this->getOrigData('identifier');
        $currentIdentifier = $this->getIdentifier();

        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }


        if (!$this->getId() || $originalIdentifier === $currentIdentifier) {
            return parent::beforeSave();
        }

        switch ($originalIdentifier) {
            case $this->getScopeConfig()->getValue(PageHelper::XML_PATH_NO_ROUTE_PAGE):
                throw new LocalizedException(
                    __('This identifier is reserved for "CMS No Route Page" in configuration.')
                );
            case $this->getScopeConfig()->getValue(PageHelper::XML_PATH_HOME_PAGE):
                throw new LocalizedException(__('This identifier is reserved for "CMS Home Page" in configuration.'));
            case $this->getScopeConfig()->getValue(PageHelper::XML_PATH_NO_COOKIES_PAGE):
                throw new LocalizedException(
                    __('This identifier is reserved for "CMS No Cookies Page" in configuration.')
                );
        }

        return parent::beforeSave();
    }
	
}
	
	