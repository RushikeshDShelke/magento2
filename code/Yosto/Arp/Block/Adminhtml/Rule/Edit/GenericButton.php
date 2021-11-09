<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Adminhtml\Rule\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class GenericButton
 * @package Yosto\Arp\Block\Adminhtml\Rule\Edit
 */
abstract class GenericButton
{

    protected $context;
    protected $registry;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(Context $context, Registry $registry)
    {
        $this->context = $context;
        $this->registry = $registry;
    }

    /**
     * Return model ID
     *
     * @return int|null
     */
    public function getModelId()
    {
        return $this->context->getRequest()->getParam('rule_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return the current Catalog Rule Id.
     *
     * @return int|null
     */
    public function getRuleId()
    {
        $rule = $this->registry->registry('yosto_arp_rule');
        return $rule ? $rule->getId() : null;
    }

    /**
     * Check where button can be rendered
     *
     * @param string $name
     * @return string
     */
    public function canRender($name)
    {
        return $name;
    }
}
