<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Arp\Controller\Adminhtml;

use Magento\Framework\View\Result\PageFactory;

/**
 * Class Rule
 * @package Yosto\Arp\Controller\Adminhtml
 */
abstract class Rule extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Yosto_Arp::arp';

    protected $resultPageFactory;
    protected $resultForwardFactory;

    protected $_coreRegistry;
    protected $_dirtyRulesNoticeMessage;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);

    }

    /**
     * @param $resultPage
     * @return mixed
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Yosto'), __('Yosto'))
            ->addBreadcrumb(__('Rule'), __('Rule'));
        return $resultPage;
    }

    /**
     * Set dirty rules notice message
     *
     * @param string $dirtyRulesNoticeMessage
     * @return void
     * @codeCoverageIgnore
     */
    public function setDirtyRulesNoticeMessage($dirtyRulesNoticeMessage)
    {
        $this->_dirtyRulesNoticeMessage = $dirtyRulesNoticeMessage;
    }

    /**
     * Get dirty rules notice message
     *
     * @return string
     */
    public function getDirtyRulesNoticeMessage()
    {
        $defaultMessage = __(
            'We found updated rules that are not applied. Please click "Apply Rules" to update your catalog.'
        );
        return $this->_dirtyRulesNoticeMessage ? $this->_dirtyRulesNoticeMessage : $defaultMessage;
    }
}
