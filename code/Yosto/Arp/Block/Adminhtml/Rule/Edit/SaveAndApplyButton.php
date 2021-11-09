<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Adminhtml\Rule\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndApplyButton
 * @package Yosto\Arp\Block\Adminhtml\Rule\Edit
 */
class SaveAndApplyButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->canRender('save_apply')) {
            $data = [
                'label' => __('Save and Apply'),
                'class' => 'save',
                'on_click' => '',
                'sort_order' => 80,
                'data_attribute' => [
                    'mage-init' => [
                        'Magento_Ui/js/form/button-adapter' => [
                            'actions' => [
                                [
                                    'targetName' => 'yosto_arp_rule_form.yosto_arp_rule_form',
                                    'actionName' => 'save',
                                    'params' => [
                                        true,
                                        ['auto_apply' => 1],
                                    ]
                                ]
                            ]
                        ]
                    ],

                ]
            ];
        }
        return $data;
    }
}