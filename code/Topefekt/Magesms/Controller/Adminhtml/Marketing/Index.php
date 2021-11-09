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
 namespace Topefekt\Magesms\Controller\Adminhtml\Marketing; use Topefekt\Magesms\Model\Sms; class Index extends \Topefekt\Magesms\Controller\Adminhtml\Marketing { private $v148194b5b9cc653ce2e35e9709e441dc6fd4123a = []; public function execute() { $this->prepareFilters(); if ($this->send()) { $this->_redirect('*/*/index'); return; } $this->_initAction(); $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Marketing SMS')); $i8ee45e0018a32fb1a855b82624506e35789cc4d2 = $this->_view->getLayout()->getBlock('magesms.marketing.index'); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setSmsData($this->getRequest()->getParams()); $id42c5963b49dec2d3a886ec5045e3b8e035c239f = '{customer_firstname}, {customer_lastname}, {customer_email}, {customer_phone}, {shop_name}, {shop_domain}, {shop_email}, {shop_phone}'; $i1ec93d6cdf7202ea32d00997e9d5b5a68e2df3bc = '{coupon_name}, {coupon_code}, {coupon_description}, {coupon_reduction_percent}, {coupon_reduction_amount}, {coupon_reduction_currency}, {coupon_date_start}, {coupon_date_end}, {coupon_quantity}'; $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setNotice($id42c5963b49dec2d3a886ec5045e3b8e035c239f); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setTranslate($this->_mageHelper->hookVariablesJS($id42c5963b49dec2d3a886ec5045e3b8e035c239f.','.$i1ec93d6cdf7202ea32d00997e9d5b5a68e2df3bc)); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setCouponsNotice($i1ec93d6cdf7202ea32d00997e9d5b5a68e2df3bc); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setCollection($this->_collection); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setTimezone($this->_timezone); $i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442 = $this->_rule->getCollection(); $i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442->addFieldToFilter('is_active', 1) ->addFieldToFilter('coupon_type', \Magento\SalesRule\Model\Rule::COUPON_TYPE_SPECIFIC); $ic6e86aba1bc36abbc0265f7e37437aa716c170c0 = [['rule_id' => '', 'name' => '- '.__('Please Select').' -']]; $ic6e86aba1bc36abbc0265f7e37437aa716c170c0 = array_merge($ic6e86aba1bc36abbc0265f7e37437aa716c170c0, $i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442->getItems()); $i8ee45e0018a32fb1a855b82624506e35789cc4d2->setCoupons($ic6e86aba1bc36abbc0265f7e37437aa716c170c0); $this->_view->renderLayout(); } protected function send() { if (!count($this->getRequest()->getPost())) return false; $iacbd1c78463510856e506611fe14b5e1173581a6 = $this->getRequest(); $idfc9fbe8edf868c14fc4a3f15c7f40aabfa080aa = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('text'); if (!$idfc9fbe8edf868c14fc4a3f15c7f40aabfa080aa) { $this->getMessageManager()->addErrorMessage(__('Fill in SMS text.')); return false; } if (!$this->_collection->count()) { $this->getMessageManager()->addErrorMessage(__('Recipients found: 0')); return false; } $ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('unicode') ? true : false; $ifc17de93671eea5715520ecfbc4dc543818685b8 = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('unique') ? true : false; $this->sms->setMessage($idfc9fbe8edf868c14fc4a3f15c7f40aabfa080aa) ->setType(Sms::TYPE_MARKETING) ->setPriority(false) ->setUnicode($ie8d90f6313614fbb6564426c0b0cb59a0ca4cecd) ->setUnique($ifc17de93671eea5715520ecfbc4dc543818685b8); if ($iacbd1c78463510856e506611fe14b5e1173581a6->getPost('sendlater') && $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('datumodesl')) { $i4c323947385ff52539168f26084feed4bc17e2dc = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('datumodesl'); $i6aa8d50211ad373efab0896425f6f5fa0e013c29 = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('datumodesl_hour'); $if8001c570b9f0e904df8b36797628015beb8fa80 = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('datumodesl_min'); $i836a3cd8c554d1c35cc3c6cf3e3f49052b683096 = $iacbd1c78463510856e506611fe14b5e1173581a6->getPost('datereal', 0); $i60d180619d48d77cb1c25f2d5bccd0e87e6df3cb = new \IntlDateFormatter( $this->_localeResolver->getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE ); $i6303535604abb0d048082bff55ee31bd1fe9c209 = $i60d180619d48d77cb1c25f2d5bccd0e87e6df3cb->parse($i4c323947385ff52539168f26084feed4bc17e2dc) + $i6aa8d50211ad373efab0896425f6f5fa0e013c29 * 3600 + $if8001c570b9f0e904df8b36797628015beb8fa80 * 60 + $i836a3cd8c554d1c35cc3c6cf3e3f49052b683096 * 3600; $this->sms->setSendlater($i6303535604abb0d048082bff55ee31bd1fe9c209); } $i66e3a0cd135d568c8d85190341325c1d3af03b4b = null; $iad9ca2238db0190a0310a03143f9935535720c34 = (int)$iacbd1c78463510856e506611fe14b5e1173581a6->getPost('coupon'); if ($iad9ca2238db0190a0310a03143f9935535720c34) { $i66e3a0cd135d568c8d85190341325c1d3af03b4b = $this->_rule->load($iad9ca2238db0190a0310a03143f9935535720c34); if ($i66e3a0cd135d568c8d85190341325c1d3af03b4b) { if ($i66e3a0cd135d568c8d85190341325c1d3af03b4b->getUseAutoGeneration()) { if (count($i66e3a0cd135d568c8d85190341325c1d3af03b4b->getCoupons()) < $this->_collection->count()) { $if3b1e2c1706de4c1bca112c669caba3a0420b880 = __('Few coupons have been generated. Generate more coupons.'); $if3b1e2c1706de4c1bca112c669caba3a0420b880 .= '<br />'.__('Number of coupons: %s', count($i66e3a0cd135d568c8d85190341325c1d3af03b4b->getCoupons())); $if3b1e2c1706de4c1bca112c669caba3a0420b880 .= '<br />'.__('Number of recipients: %s', $this->_collection->count()); $this->getMessageManager()->addErrorMessage($if3b1e2c1706de4c1bca112c669caba3a0420b880); return; } } if ($i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442 = $i66e3a0cd135d568c8d85190341325c1d3af03b4b->getCoupons()) { $i66e3a0cd135d568c8d85190341325c1d3af03b4b->setCoupon(current($i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442)); } } } foreach ($this->_collection as $iff7e46827cbb6547116c592bf800f4687428abf9) { if ($iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()) { if (isset($this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a['website_'.$iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()])) { $i9fdb3b1e2e6984ebdd1220ec199279013c5483fc = $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a['website_'.$iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()]; $ic5616185277631275bc74b85565c0c6eed62a3cd = $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a['store-id_'.$iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()]; } else { $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a['website_'.$iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()] = $i06a381e12f304723bef83828539567b279a48b64 = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class); $i9fdb3b1e2e6984ebdd1220ec199279013c5483fc = $i06a381e12f304723bef83828539567b279a48b64->getWebsite($iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()); $this->v148194b5b9cc653ce2e35e9709e441dc6fd4123a['store-id_'.$iff7e46827cbb6547116c592bf800f4687428abf9->getWebsiteId()] = $ic5616185277631275bc74b85565c0c6eed62a3cd = $i9fdb3b1e2e6984ebdd1220ec199279013c5483fc->getStoreId(); } } else { $ic5616185277631275bc74b85565c0c6eed62a3cd = null; } $this->sms->addRecipient($iff7e46827cbb6547116c592bf800f4687428abf9->getTelephone(), [ 'country' => $iff7e46827cbb6547116c592bf800f4687428abf9->getCountryId(), 'customerId' => $iff7e46827cbb6547116c592bf800f4687428abf9->getId(), 'recipient' => $iff7e46827cbb6547116c592bf800f4687428abf9->getFirstname().' '.$iff7e46827cbb6547116c592bf800f4687428abf9->getLastname(), 'text' => $this->_mageHelper->prepareText($idfc9fbe8edf868c14fc4a3f15c7f40aabfa080aa, $ic5616185277631275bc74b85565c0c6eed62a3cd, $iff7e46827cbb6547116c592bf800f4687428abf9, $i66e3a0cd135d568c8d85190341325c1d3af03b4b), 'dnd' => !(($i17dbc08b33778f0cb7ec2da29ca88fea8caf1bf1 = $iff7e46827cbb6547116c592bf800f4687428abf9->getMagesmsCustomerMarketing()) ? $i17dbc08b33778f0cb7ec2da29ca88fea8caf1bf1 : is_null($i17dbc08b33778f0cb7ec2da29ca88fea8caf1bf1) ? 1 : $i17dbc08b33778f0cb7ec2da29ca88fea8caf1bf1), ] ); if ($i66e3a0cd135d568c8d85190341325c1d3af03b4b && $i66e3a0cd135d568c8d85190341325c1d3af03b4b->getUseAutoGeneration()) { $i66e3a0cd135d568c8d85190341325c1d3af03b4b->setCoupon(next($i3e3a0f2ae6a0c8837eef43b5d93ce2acef452442)); } } return $this->sms->send(); } public function _initAction() { parent::_initAction(); $this->_addBreadcrumb(__('Marketing SMS'), __('Marketing SMS')); return $this; } protected function _isAllowed() { return $this->_authorization->isAllowed('Topefekt_Magesms::magesms_marketing'); } } 