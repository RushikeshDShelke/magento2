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
 namespace Topefekt\Magesms\Controller\Adminhtml\Marketing; use Magento\Framework\DataObject; class Validate extends \Topefekt\Magesms\Controller\Adminhtml\Marketing { public function execute() { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e = new DataObject(); $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(false); if (!$this->getRequest()->getPost()) { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(true); return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } if (!$this->getRequest()->getParam('text')) { $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setError(true); $ia1a238c1f12f3901520c7ca55efa646e471f7f6e->setMessage(__('Fill in SMS text.')); return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } return $this->resultJsonFactory->create()->setData($ia1a238c1f12f3901520c7ca55efa646e471f7f6e); } } 