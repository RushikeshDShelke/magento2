<?php
/**
 * Mage SMS - SMS notification & SMS marketing
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the BSD 3-Clause License
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/BSD-3-Clause
 *
 * @category    TOPefekt
 * @package     TOPefekt_Magesms
 * @copyright   Copyright (c) 2012-2017 TOPefekt s.r.o. (http://www.mage-sms.com)
 * @license     http://opensource.org/licenses/BSD-3-Clause
 */
namespace Topefekt\Magesms\Block\System\Config; class Apikeygenerator extends \Magento\Config\Block\System\Config\Form\Field { protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $id23e685c18c58238831a9a9f8356004faff20ddc) { $i0351976a9053ff0d3893ad32bf0b51e106252b6d = $this->getLayout()->createBlock( 'Magento\Backend\Block\Widget\Button' ); $i0351976a9053ff0d3893ad32bf0b51e106252b6d->setData( [ 'type' => 'button', 'label' => __('Generator new API key'), 'on_click' => "document.getElementById('magesms_api_apikey').value = 'xxxxxx-xxxx-yxxx-yxxx-xxxxxx'.replace(/[xy]/g, function(c) {var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);return v.toString(16);});" ] ); return parent::_getElementHtml($id23e685c18c58238831a9a9f8356004faff20ddc).$i0351976a9053ff0d3893ad32bf0b51e106252b6d->toHtml(); } } 