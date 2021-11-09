<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Block\Adminhtml\Rule\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\App\ObjectManager;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

/**
 * Class WhereConditions
 * @package Yosto\Arp\Block\Adminhtml\Rule\Edit\Tab
 */
class WhereConditions extends Generic implements TabInterface
{
    /**
     * @var \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
     */
    protected $_rendererFieldset;

    /**
     * @var \Magento\Rule\Block\Conditions|\Yosto\Arp\Block\Rule\WhereConditions
     */
    protected $_conditions;


    /**
     * @var \Yosto\Arp\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var string
     */
    protected $_nameInLayout = 'where_conditions_apply_to';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Rule\Block\Conditions $conditions
     * @param \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Yosto\Arp\Block\Rule\WhereConditions $conditions,
        \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset,
        array $data = []
    ) {
        $this->_rendererFieldset = $rendererFieldset;
        $this->_conditions = $conditions;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare content for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabLabel()
    {
        return __('Conditions');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabTitle()
    {
        return __('Conditions');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Tab class getter
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getTabClass()
    {
        return null;
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getTabUrl()
    {
        return null;
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isAjaxLoaded()
    {
        return false;
    }

    /**
     * @return Form
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('yosto_arp_rule');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->addTabToForm($model);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * The getter function to get the new RuleFactory dependency
     *
     * @return \Yosto\Arp\Model\RuleFactory
     *
     * @deprecated
     */
    private function getRuleFactory()
    {
        if ($this->ruleFactory === null) {
            $this->ruleFactory = ObjectManager::getInstance()->get('Yosto\Arp\Model\RuleFactory');
        }
        return $this->ruleFactory;
    }


    /**
     * @param \Yosto\Arp\Model\Rule $model
     * @param string $whereFieldsetId
     * @param string $formName
     * @return \Magento\Framework\Data\Form
     */
    protected function addTabToForm(
        $model,
        $whereFieldsetId = 'where_conditions_fieldset',
        $formName = 'yosto_arp_rule_form'
    ) {
        if (!$model) {
            $id = $this->getRequest()->getParam('rule_id');
            $model = $this->getRuleFactory()->create();
            $model->load($id);
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('where_rule_');

        $newChildUrl = $this->getUrl(
            'yosto_arp/rule/newWhereConditionHtml/form/' . $model->getConditionsFieldSetId($formName, 'where_conditions' ),
            ['form_namespace' => $formName]
        );

        $renderer = $this->_rendererFieldset->setTemplate('Magento_CatalogRule::promo/fieldset.phtml')
            ->setNewChildUrl($newChildUrl)
            ->setFieldSetId($model->getConditionsFieldSetId($formName, 'where_conditions'));

        $whereFieldset = $form->addFieldset(
            $whereFieldsetId,
            ['legend' => __('Conditions (add conditions to apply rule for products)')]
        )->setRenderer($renderer);

        $whereFieldset->addField(
            'where_conditions',
            'text',
            [
                'name' => 'where_conditions',
                'label' => __('Where to display'),
                'title' => __('Where to display'),
                'required' => true,
                'data-form-part' => $formName
            ]
        )
            ->setRule($model)
            ->setRenderer($this->_conditions);

        $form->setValues($model->getData());
        $this->setConditionFormName($model->getWhereConditions(), $formName);
        return $form;
    }

    /**
     * @param \Magento\Rule\Model\Condition\AbstractCondition $conditions
     * @param $formName
     */
    private function setConditionFormName(\Magento\Rule\Model\Condition\AbstractCondition $conditions, $formName)
    {
        $conditions->setFormName($formName);
        if ($conditions->getWhereConditions() && is_array($conditions->getWhereConditions())) {
            foreach ($conditions->getWhereConditions() as $condition) {
                $this->setConditionFormName($condition, $formName);
            }
        }
    }
}