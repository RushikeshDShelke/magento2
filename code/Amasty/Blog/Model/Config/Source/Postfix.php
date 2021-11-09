<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Postfix
 */
class Postfix implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('No Postfix')],
            ['value' => '.html', 'label' => __('.html')]
        ];
    }
}
