<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Controller\Adminhtml\Rule;

use Magento\Framework\App\ResponseInterface;
use Magento\Rule\Model\Condition\AbstractCondition;
use Yosto\Arp\Controller\Adminhtml\Rule;

/**
 * Class NewWhatConditionHtml
 * @package Yosto\Arp\Controller\Adminhtml\Rule
 */
class NewWhatConditionHtml extends Rule
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $formName = $this->getRequest()->getParam('form_namespace');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];
        /** @var  $model */
        $model = $this->_objectManager->create($type)
            ->setId($id)
            ->setType($type)
            ->setRule($this->_objectManager->create('Yosto\Arp\Model\Rule'))
            ->setPrefix('what_conditions');

        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof AbstractCondition) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $model->setFormName($formName);
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }

}