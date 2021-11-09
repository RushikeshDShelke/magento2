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
namespace Topefekt\Magesms\Controller\Adminhtml\History; class Index extends \Topefekt\Magesms\Controller\Adminhtml\History { const PAGE_SIZE = 50; public function execute() { $iff7e46827cbb6547116c592bf800f4687428abf9 = $this->getHistoryFactory()->create()->getCollection() ->setOrder('date', 'DESC'); $i0c7af627af1b0c4994a21f04816fdd8fa7b16c11 = $this->getRequest()->getParam('page', 1); $i08037e6e302c97fb0926a48b2f827fcfaee38ffe = $this->getRequest()->getParam('rok', date('Y')); $i99b4e24c770f0c62c04355a8b5223162f1589293 = $this->getRequest()->getParam('mesic'); $i2aa3938fb4a41a5cf7dcbd2b67c1592e14e664f8 = $this->getRequest()->getParam('den'); if ($i2aa3938fb4a41a5cf7dcbd2b67c1592e14e664f8 && $i99b4e24c770f0c62c04355a8b5223162f1589293) { $iff7e46827cbb6547116c592bf800f4687428abf9->getSelect()->where("`date` LIKE ?", sprintf("%04d-%02d-%02d%%", $i08037e6e302c97fb0926a48b2f827fcfaee38ffe, $i99b4e24c770f0c62c04355a8b5223162f1589293, $i2aa3938fb4a41a5cf7dcbd2b67c1592e14e664f8)); } elseif ($i99b4e24c770f0c62c04355a8b5223162f1589293) { $iff7e46827cbb6547116c592bf800f4687428abf9->getSelect()->where("`date` LIKE ?", sprintf("%04d-%02d-%%", $i08037e6e302c97fb0926a48b2f827fcfaee38ffe, $i99b4e24c770f0c62c04355a8b5223162f1589293)); } else { $iff7e46827cbb6547116c592bf800f4687428abf9->getSelect()->where("`date` > ?", sprintf("%04d-01-01", $i08037e6e302c97fb0926a48b2f827fcfaee38ffe)); } if (($i6dc291db3e1b662b3da435666456bf9c7b8f9206 = $this->getRequest()->getParam('status'))) { $iff7e46827cbb6547116c592bf800f4687428abf9->addFilter('status', $i6dc291db3e1b662b3da435666456bf9c7b8f9206); } $i83e615fa5ecf9291e01ccef41ed5ec1bce147664 = []; if ($this->getRequest()->getParam('eshopsms', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 2; if ($this->getRequest()->getParam('eshopsms1', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 1; if ($this->getRequest()->getParam('bulksms', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 3; if ($this->getRequest()->getParam('bulksms2', 1) != 1) $i83e615fa5ecf9291e01ccef41ed5ec1bce147664[] = 4; if (count($i83e615fa5ecf9291e01ccef41ed5ec1bce147664)) { $iff7e46827cbb6547116c592bf800f4687428abf9->getSelect()->where("`type` NOT IN (?)", $i83e615fa5ecf9291e01ccef41ed5ec1bce147664); } $iff7e46827cbb6547116c592bf800f4687428abf9->setPageSize(self::PAGE_SIZE); $iff7e46827cbb6547116c592bf800f4687428abf9->setCurPage($i0c7af627af1b0c4994a21f04816fdd8fa7b16c11); if ($iff7e46827cbb6547116c592bf800f4687428abf9->getSize()) { $i3ad1587c5e634f88620f6fbe7aec68e06b35aedc = ($i0c7af627af1b0c4994a21f04816fdd8fa7b16c11 - 1) * self::PAGE_SIZE + 1; $i59c054dfefe7a5ed41deddfad6b89cf79a03a915 = ($i0c7af627af1b0c4994a21f04816fdd8fa7b16c11 - 1) * self::PAGE_SIZE + self::PAGE_SIZE; if ($i59c054dfefe7a5ed41deddfad6b89cf79a03a915 > $iff7e46827cbb6547116c592bf800f4687428abf9->getSize()) $i59c054dfefe7a5ed41deddfad6b89cf79a03a915 = $iff7e46827cbb6547116c592bf800f4687428abf9->getSize(); $this->getRequest()->setParam('page', null); $this->getCoreRegistry()->register('history_from', $i3ad1587c5e634f88620f6fbe7aec68e06b35aedc); $this->getCoreRegistry()->register('history_to', $i59c054dfefe7a5ed41deddfad6b89cf79a03a915); } $this->getCoreRegistry()->register('history', $iff7e46827cbb6547116c592bf800f4687428abf9); $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('SMS History')); $this->_view->renderLayout(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('SMS History'), __('SMS History')); return $this; } } 