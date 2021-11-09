<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author salmatsaiyad
 */

namespace Themecafe\CCAvenue\Block;

class Info extends \Magento\Payment\Block\Info {

    protected $_template = 'Themecafe_CCAvenue::info/default.phtml';

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = array()) {
        parent::__construct($context, $data);
    }

    /**
     * Retrieve info model
     *
     * @return \Magento\Payment\Model\InfoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPaymentBy() {
        /* echo '<pre>';
          print_r($this->getInfo()->getTransactionAdditionalInfo());
          echo '===================================';
          print_r($this->getInfo()->getAdditionalData());
          echo '**********************************';
          print_r($this->getInfo()->getAdditionalInformation()); */
        $data = $this->getInfo()->getAdditionalInformation();
        if (!empty($data) && isset($data['payment_mode'])):
            return ' - ' . $data['payment_mode'];
        else:
            return '';
        endif;
    }

}
