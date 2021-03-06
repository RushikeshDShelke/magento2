<?php
/**
 * Venustheme
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Venustheme.com license that is
 * available through the world-wide-web at this URL:
 * http://www.venustheme.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Venustheme
 * @package    Ves_Trackorder
 * @copyright  Copyright (c) 2014 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

namespace Ves\Trackorder\Block\Order; 
class Buttons extends \Magento\Sales\Block\Order\Info\Buttons
{ 
    protected $_template = 'order/info/buttons.phtml'; 

    public function getPrintOrderUrl($order)
    { 
        return $this->getUrl('*/*/print', ['order_id' => $order->getId()]);
    }

    public function getSendEmailUrl($order)
    { 
        return $this->getUrl('*/*/send', ['order_id' => $order->getId()]);
    }
}
