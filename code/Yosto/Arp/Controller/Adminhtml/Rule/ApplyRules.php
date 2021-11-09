<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Controller\Adminhtml\Rule;


use Magento\Framework\Controller\ResultFactory;
use Yosto\Arp\Controller\Adminhtml\Rule;
use Yosto\Arp\Model\Rule\Job;

/**
 * Apply all rules
 *
 * Class ApplyRules
 * @package Yosto\Arp\Controller\Adminhtml\Rule
 */
class ApplyRules extends Rule
{
    /**
     * Apply all active catalog price rules
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $errorMessage = __('We can\'t apply the rules.');
        try {
            /** @var Job $ruleJob */
            $ruleJob = $this->_objectManager->get('Yosto\Arp\Model\Rule\Job');
            $ruleJob->applyAll();

            if ($ruleJob->hasSuccess()) {
                $this->messageManager->addSuccessMessage($ruleJob->getSuccess());
                $this->_objectManager->create('Yosto\Arp\Model\Flag')->loadSelf()->setState(0)->save();
            } elseif ($ruleJob->hasError()) {
                $this->messageManager->addErrorMessage($errorMessage . ' ' . $ruleJob->getError());
            }
        } catch (\Exception $e) {
            $this->_objectManager->create('Psr\Log\LoggerInterface')->critical($e);
            $this->messageManager->addErrorMessage($errorMessage);
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('yosto_arp/*');
    }
}