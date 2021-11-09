<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Controller\Adminhtml\Rule;

use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Yosto\Arp\Controller\Adminhtml\Rule
 */
class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('rule_id');
            /** @var \Yosto\Arp\Model\Rule $model */
            $model = $this->_objectManager->create('Yosto\Arp\Model\Rule')->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Rule no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }


            $validateResult = $model->validateData(new \Magento\Framework\DataObject($data));
            if ($validateResult !== true) {
                foreach ($validateResult as $errorMessage) {
                    $this->messageManager->addErrorMessage($errorMessage);
                }
                $this->_getSession()->setPageData($data);
                $this->dataPersistor->set('yosto_arp_rule', $data);
                $this->_redirect('yosto_arp/*/edit', ['rule_id' => $model->getId()]);
                return;
            }


            if (isset($data['rule']['what_conditions'])) {
                $data['what_conditions'] = $data['rule']['what_conditions'];
            }
            if (isset($data['rule']['where_conditions'])) {
                $data['where_conditions'] = $data['rule']['where_conditions'];
            }
            unset($data['rule']);
            $model->loadPost($data);

            //$model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Rule.'));
                $this->dataPersistor->clear('yosto_arp_rule');

                /**
                 * Auto apply rules
                 */
                if ($this->getRequest()->getParam('auto_apply')) {
                    $this->getRequest()->setParam('rule_id', $model->getId());
                    $this->_forward('applyRules');
                } else {
                    if ($model->isRuleBehaviorChanged()) {
                        $this->_objectManager
                            ->create('Yosto\Arp\Model\Flag')
                            ->loadSelf()
                            ->setState(1)
                            ->save();
                    }
                    if ($this->getRequest()->getParam('back')) {

                        return $this->_redirect('yosto_arp/*/edit', ['rule_id' => $model->getId()]);
                    }
                    $this->_redirect('yosto_arp/*/');
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Rule.'));
            }
        
            $this->dataPersistor->set('yosto_arp_rule', $data);
            return $resultRedirect->setPath('*/*/edit', ['rule_id' => $this->getRequest()->getParam('rule_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
