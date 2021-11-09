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
 namespace Topefekt\Magesms\Controller\Adminhtml\Customersms; class Save extends \Topefekt\Magesms\Controller\Adminhtml\Customersms { public function execute() { $i7137e40370cf1c5ccf937060891613788203e2d6 = $this->getRequest()->getParam('mutation', 'default'); $i30f20aafde612a957f7f966cb5b85e35782bc88a = $this->getRequest()->getParam('type'); $i2bd9743336318d0e14be0600c9129730279505dd = $this->getRequest()->getParam('name'); $i24273814df383b4a6926acc1db1a788b12f5a411 = $this->getRequest()->getParam('text' , ''); if ($i30f20aafde612a957f7f966cb5b85e35782bc88a && in_array($i30f20aafde612a957f7f966cb5b85e35782bc88a, ['admins', 'customers']) && $i2bd9743336318d0e14be0600c9129730279505dd && $i24273814df383b4a6926acc1db1a788b12f5a411) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $if739aceffec69fa2733946a3d319defaa354082d = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->get('Topefekt\Magesms\Model\Hooks\\'.ucwords($i30f20aafde612a957f7f966cb5b85e35782bc88a))->getCollection(); $i42ee48f418943c9662de0976069476c7dc8f620d = $if739aceffec69fa2733946a3d319defaa354082d->addFieldToFilter('name', $i2bd9743336318d0e14be0600c9129730279505dd) ->addFieldToFilter('mutation', $i7137e40370cf1c5ccf937060891613788203e2d6) ->getFirstItem(); if (!$if739aceffec69fa2733946a3d319defaa354082d->count()) { $i42ee48f418943c9662de0976069476c7dc8f620d = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create('Topefekt\Magesms\Model\Hooks\\'.ucwords($i30f20aafde612a957f7f966cb5b85e35782bc88a)); $i42ee48f418943c9662de0976069476c7dc8f620d->setMutation($i7137e40370cf1c5ccf937060891613788203e2d6) ->setName($i2bd9743336318d0e14be0600c9129730279505dd) ->setSmstext($i24273814df383b4a6926acc1db1a788b12f5a411); } $i42ee48f418943c9662de0976069476c7dc8f620d->setActive($this->getRequest()->getParam('active' , 0)) ->setSmstext($i24273814df383b4a6926acc1db1a788b12f5a411) ->save(); $this->messageManager->addSuccessMessage(__('Text of SMS was saved.')); } $ia8a35a47a8e61218e15d1a33dac64bdc2449c01a = ['_fragment' => $i2bd9743336318d0e14be0600c9129730279505dd]; if ($i7137e40370cf1c5ccf937060891613788203e2d6 != 'default') $ia8a35a47a8e61218e15d1a33dac64bdc2449c01a += ['mutation' => $i7137e40370cf1c5ccf937060891613788203e2d6]; $this->_redirect('*/*/', $ia8a35a47a8e61218e15d1a33dac64bdc2449c01a); } } 