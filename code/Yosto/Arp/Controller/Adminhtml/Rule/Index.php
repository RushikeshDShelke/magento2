<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Controller\Adminhtml\Rule;

use Yosto\Arp\Controller\Adminhtml\Rule;

/**
 * Class Index
 * @package Yosto\Arp\Controller\Adminhtml\Rule
 */
class Index extends Rule
{

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $dirtyRules = $this->_objectManager->create('Yosto\Arp\Model\Flag')->loadSelf();
        $this->_eventManager->dispatch(
            'yosto_arp_rule_dirty_notice',
            ['dirty_rules' => $dirtyRules, 'message' => $this->getDirtyRulesNoticeMessage()]
        );
        $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__("Rules"));
            return $resultPage;
    }
}
