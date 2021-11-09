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
 namespace Topefekt\Magesms\Controller\Adminhtml\Adminsms; class Save extends \Topefekt\Magesms\Controller\Adminhtml\Adminsms { public function execute() { $i30f20aafde612a957f7f966cb5b85e35782bc88a = $this->getRequest()->getParam('type'); $i2bd9743336318d0e14be0600c9129730279505dd = $this->getRequest()->getParam('name'); $i24273814df383b4a6926acc1db1a788b12f5a411 = $this->getRequest()->getParam('text' , ''); if ($i30f20aafde612a957f7f966cb5b85e35782bc88a && in_array($i30f20aafde612a957f7f966cb5b85e35782bc88a, ['admins', 'customers']) && $i2bd9743336318d0e14be0600c9129730279505dd && $i24273814df383b4a6926acc1db1a788b12f5a411) { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $if739aceffec69fa2733946a3d319defaa354082d = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->get('Topefekt\Magesms\Model\Hooks\\'.ucwords($i30f20aafde612a957f7f966cb5b85e35782bc88a))->getCollection(); $if739aceffec69fa2733946a3d319defaa354082d->addFieldToFilter('name', $i2bd9743336318d0e14be0600c9129730279505dd); foreach($if739aceffec69fa2733946a3d319defaa354082d as $i42ee48f418943c9662de0976069476c7dc8f620d) { $i42ee48f418943c9662de0976069476c7dc8f620d->delete(); } foreach($this->getRequest()->getParams() as $i670253c23c6fcba76bc4256a88fdd8fbc1041039=>$iacbd1c78463510856e506611fe14b5e1173581a6) { if (strpos($i670253c23c6fcba76bc4256a88fdd8fbc1041039, 'active_') === 0) { $ia61712c27ea241bd7a543dc2b02ea572274d0322 = explode('_', $i670253c23c6fcba76bc4256a88fdd8fbc1041039); $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create('Topefekt\Magesms\Model\Hooks\\'.ucwords($i30f20aafde612a957f7f966cb5b85e35782bc88a)) ->setName($i2bd9743336318d0e14be0600c9129730279505dd) ->setSmstext($i24273814df383b4a6926acc1db1a788b12f5a411) ->setAdminId($ia61712c27ea241bd7a543dc2b02ea572274d0322[2]) ->setStoreGroupId($ia61712c27ea241bd7a543dc2b02ea572274d0322[3]) ->save(); } else { continue; } } $this->messageManager->addSuccessMessage(__('Text of SMS was saved.')); } $ia8a35a47a8e61218e15d1a33dac64bdc2449c01a = array('_fragment' => $i2bd9743336318d0e14be0600c9129730279505dd); $this->_redirect('*/*/', $ia8a35a47a8e61218e15d1a33dac64bdc2449c01a); } } 