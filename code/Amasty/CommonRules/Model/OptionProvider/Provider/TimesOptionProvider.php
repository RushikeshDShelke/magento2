<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_CommonRules
 */


namespace Amasty\CommonRules\Model\OptionProvider\Provider;

class TimesOptionProvider implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array|null
     */
    protected $options;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $timeArray = [];
            $timeArray[0] = __('Please select...');

            for ($i = 0; $i < 24; $i++) {
                for ($j = 0; $j < 60; $j = $j + 15) {
                    $timeStamp = $i . ':' . $j;
                    $timeFormat = date('H:i', strtotime($timeStamp));
                    $timeArray[$i * 100 + $j + 1] = $timeFormat;
                }
            }

            $this->options = $timeArray;
        }

        return $this->options;
    }
}
