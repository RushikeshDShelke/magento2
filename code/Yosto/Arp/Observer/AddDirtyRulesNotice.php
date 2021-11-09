<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class AddDirtyRulesNotice
 * @package Yosto\Arp\Observer
 */
class AddDirtyRulesNotice implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * AddDirtyRulesNotice constructor.
     *
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(ManagerInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $dirtyRules = $observer->getData('dirty_rules');
        if (!empty($dirtyRules)) {
            if ($dirtyRules->getState()) {
                $this->messageManager->addNoticeMessage($observer->getData('message'));
            }
        }
    }
}
