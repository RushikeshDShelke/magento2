<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Model\Rule\Metadata;

use Yosto\Arp\Model\Rule\Form\BlockPosition;
use Yosto\Arp\Model\Rule\Form\Layout;
use Yosto\Arp\Model\Rule\Form\SortBy;

/**
 * Class ValueProvider
 * @package Yosto\Arp\Model\Rule\Metadata
 */
class ValueProvider
{
    protected $_blockPosition;
    protected $_layout;
    protected $_sortBy;

    /**
     * ValueProvider constructor.
     * @param BlockPosition $blockPosition
     * @param Layout $layout
     * @param SortBy $sortBy
     */
    function __construct(
        BlockPosition $blockPosition,
        Layout $layout,
        SortBy $sortBy
    ) {
        $this->_blockPosition = $blockPosition;
        $this->_layout = $layout;
        $this->_sortBy = $sortBy;
    }

    public function getMetadataValues()
    {
        return [
            'general' => [
                'children' => [
                    'block_position' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->_blockPosition->toOptionArray(),
                                ],
                            ],
                        ],
                    ]
                ]
            ],
            'how_to_display' => [
                'children' => [
                    'layout' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->_layout->toOptionArray(),
                                ],
                            ],
                        ],
                    ],
                    'sort_by' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->_sortBy->toOptionArray(),
                                ],
                            ],
                        ],
                    ]
                ]
            ],
        ];
    }

}