<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Themecafe\CCAvenue\Model\Config\Source;

class Integrationtechniques implements \Magento\Framework\Option\ArrayInterface
{
    
    public function toOptionArray() {
        return array(
            array( 'value' => 'redirect', 'label' => __('Redirect') ),
            array( 'value' => 'iframe', 'label' => __('IFRAME') ),
        );
    }

    public function toArray() {
        return array(
            'redirect' => __('Redirect'),
            'iframe' => __('Iframe'),
        );
    }
}