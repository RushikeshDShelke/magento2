<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Controller\Adminhtml\Rule;
/**
 * Class Edit
 * @package Yosto\Arp\Controller\Adminhtml\Rule
 */
class Edit extends \Yosto\Arp\Controller\Adminhtml\Rule
{



    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('rule_id');

        /** @var \Yosto\Arp\Model\Rule $model */
        $model = $this->_objectManager->create('Yosto\Arp\Model\Rule');
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Rule no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            //$model->setData('website_ids', $model->getWebsiteIds());
           // $model->setData('customer_group_ids', $model->getCustomerGroupIds());
        }

        /**
         * Set js form name, if not the system can not know what form for return value
         */
        $model->getWhereConditions()->setFormName('yosto_arp_rule_form');
        $model->getWhatConditions()->setFormName('yosto_arp_rule_form');
        $model->getWhereConditions()->setJsFormObject(
            $model->getConditionsFieldSetId(
                $model->getWhereConditions()->getFormName(),
                'where_conditions'
            )
        );

        $model->getWhatConditions()->setJsFormObject(
            $model->getConditionsFieldSetId($model->getWhatConditions()->getFormName(),
                'what_conditions')
        );


        $this->_coreRegistry->register('yosto_arp_rule', $model);

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Rule') : __('New Rule'),
            $id ? __('Edit Rule') : __('New Rule')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Rules'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Rule'));
        return $resultPage;
    }
}
