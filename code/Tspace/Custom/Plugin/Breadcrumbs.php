<?php

namespace Tspace\Custom\Plugin;

class Breadcrumbs extends \Magento\Catalog\Block\Breadcrumbs
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Data $catalogData,
        array $data = array()) {
        parent::__construct($context, $catalogData, $data);
    }
    protected function _prepareLayout()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {


            $title = [];
            $path = $this->_catalogData->getBreadcrumbPath();

            foreach ($path as $name => $breadcrumb) {
                $breadcrumbsBlock->addCrumb($name, $breadcrumb);
                $title[] = $breadcrumb['label'];
            }

            $this->pageConfig->getTitle()->set(join($this->getTitleSeparator(), array_reverse($title)));
        }
        return \Magento\Framework\View\Element\Template::_prepareLayout();
    }


}