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
 namespace Topefekt\Magesms\Block\Adminhtml\Marketing; class Filter extends \Magento\Widget\Block\Adminhtml\Widget\Form { protected function _prepareForm() { $id7c8c8e1d1b44e9917ce2ae9b4c7d03e2a3ab683 = $this->getUrl('*/*/filter', ['action' => 'applyFilter']); $i1791b2d1f89bb2bd83b34046f59125af207713db = $this->_formFactory->create(); $i1791b2d1f89bb2bd83b34046f59125af207713db->setData(['id' => 'marketing_filter', 'action' => $id7c8c8e1d1b44e9917ce2ae9b4c7d03e2a3ab683, 'method' => 'post']); $i5a4070f5dbe2b3be0f175bc31d21ce8a0e2e76dd = 'magesms_marketing_'; $i1791b2d1f89bb2bd83b34046f59125af207713db->setHtmlIdPrefix($i5a4070f5dbe2b3be0f175bc31d21ce8a0e2e76dd); $i1791b2d1f89bb2bd83b34046f59125af207713db->setUseContainer(true); $i1791b2d1f89bb2bd83b34046f59125af207713db->addField('customer_not', 'hidden', [ 'name' => 'customer_not', ]); $i00f9b0a11b6d8c15e9d603e29ad96b2c88140a51 = $i1791b2d1f89bb2bd83b34046f59125af207713db->addFieldset('base_fieldset', [ 'legend' => __('SMS Marketing - bulk SMS filter'), ] ); $i6710129c3d74d2fb5df97ccbaab2621e9e5c1bf9 = '<a title="'.__('Reset Filter').'" data-mage-init=\'{"Topefekt_Magesms/js/marketing/reset-filter":{}}\' href="'.$this->getUrl('*/*/filter', ['action' => 'reset']).'">['.__('Reset Filter').']</a>'; $i00f9b0a11b6d8c15e9d603e29ad96b2c88140a51->setHeaderBar($i6710129c3d74d2fb5df97ccbaab2621e9e5c1bf9); $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 = $this->_coreRegistry->registry('magesms_marketing_filters'); $i00f9b0a11b6d8c15e9d603e29ad96b2c88140a51->addField('filters', 'select', [ 'name' => 'filters', 'options' => $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2->getFilters(), ]); $i0351976a9053ff0d3893ad32bf0b51e106252b6d = $this->getButtonHtml(__('Apply filter'), '', 'primary', 'magesms_apply_filter'); $i8114d84b871449f246242a4433e364f848daff0c = '<script type="text/x-magento-init">
{
	"#magesms_marketing_filters":
	{
		"Topefekt_Magesms/js/marketing/load-filter": { "url": "'.$this->getUrl('*/*/filter', ['action' => 'loadFilter']).'" } 
	},
	"#magesms_apply_filter":
	{
		"Topefekt_Magesms/js/marketing/apply-filter": {} 
	}
}
</script>'; $i00f9b0a11b6d8c15e9d603e29ad96b2c88140a51->setHtmlContent('<p id="magesms_applied_filters">'.$this->getHtmlFilters().'</p>'.$i00f9b0a11b6d8c15e9d603e29ad96b2c88140a51->getChildrenHtml().'<span id="magesms_load_filter"></span>'.$i0351976a9053ff0d3893ad32bf0b51e106252b6d.$i8114d84b871449f246242a4433e364f848daff0c); $this->setForm($i1791b2d1f89bb2bd83b34046f59125af207713db); } public function getHtmlFilters() { $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e = \Magento\Framework\App\ObjectManager::getInstance(); $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 = $i91f38bff7110fc85a77a8fd1a2cbfe902aa46e9e->create(\Topefekt\Magesms\Model\Marketing\Filter\Collection::class); $id82aaf2f437652c4b6efbd55703199f614e8e516 = ''; foreach($i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2->getAppliedFilters() as $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538=>$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { $ib605a096f442fa4dba073a8f5d37efb1add4650f = str_replace(':', '', $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['title']); $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89 = $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getLabel() ? $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getLabel() : $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValue(); if (is_array($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89) && isset($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['cond']) ) $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89 = $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['cond'].$if2eee0665f163a28f4adcfe84e3fc666bf1bcd89[1]; elseif (is_array($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89)) { $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89 = $if2eee0665f163a28f4adcfe84e3fc666bf1bcd89[0].$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['glue'].$if2eee0665f163a28f4adcfe84e3fc666bf1bcd89[1]; } $id82aaf2f437652c4b6efbd55703199f614e8e516 .= '<span class="badge" style="background: '.$iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->filter['color'].'">'. $ib605a096f442fa4dba073a8f5d37efb1add4650f.': '.$if2eee0665f163a28f4adcfe84e3fc666bf1bcd89. ' <span class="delete"  data-mage-init=\'{"Topefekt_Magesms/js/marketing/remove-filter": {"url":"'. $this->getUrl('*/*/filter', ['action' => 'removeFilter', 'id' => $i7d411c0cc32cdb65ec82b9e8d79aa996946f5538]).'"}}\'>x</span></span>'; } return $id82aaf2f437652c4b6efbd55703199f614e8e516; } }