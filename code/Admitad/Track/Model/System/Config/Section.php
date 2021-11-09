<?php

namespace Admitad\Track\Model\System\Config;

use Admitad\Track\Helper\Admitad;
use Admitad\Track\Helper\Data;
use \Magento\Config\Model\Config\Structure\Element\Section as OriginalSection;
use \Magento\Framework\ObjectManagerInterface;

class Section
{

    const CONFIG_GENERAL_SECTION_ID = 'admitadtrack';

    const GROUP_PATH_PREFIX = 'actions';

    const TAB_ID = 'actions';

    private $helper;

    private $objectManager;

    private $admitad;

    private $categoryList;

    private $done = false;

    public function __construct(
        ObjectManagerInterface $objectManager,
        Data $helper,
        Admitad $admitad,
        Categorylist $categoryList
    ) {
        $this->helper = $helper;
        $this->admitad = $admitad;
        $this->objectManager = $objectManager;
        $this->categoryList = $categoryList;
    }

    /**
     * @return array
     */
    private function getDynamicConfigGroups()
    {
        $info = $this->admitad->getAdvertiserInfo();
        if (empty($info)) {
            return [];
        }

        $this->helper->setGeneralConfig('admitad_campaign_code', $info['campaign_code']);
        $this->helper->setGeneralConfig('admitad_postback_key', $info['postback_key']);

        $dynamicConfigGroups = [];
        foreach (Admitad::getOrderTypes() as $type => $name) {
            foreach ($info['actions'] as $index => $action) {
                $dynamicConfigFields = [];

                $dynamicConfigFields['type-' . $type .'-action-' . $action['action_code']] = [
                    'id'            => 'type-' . $type .'-action-' . $action['action_code'],
                    'type'          => 'select',
                    'sortOrder'     => ($index * 10),
                    'showInDefault' => '1',
                    'showInWebsite' => '0',
                    'showInStore'   => '0',
                    'label'         => __('Action'),
                    'options'       => [
                        'option' => Admitad::getAvailableTypes(),
                    ],
                    '_elementType'  => 'field',
                    'path'          => implode(
                        '/',
                        [
                            static::CONFIG_GENERAL_SECTION_ID,
                            static::GROUP_PATH_PREFIX,
                        ]
                    ),
                ];

                foreach ($action['tariffs'] as $tariff) {
                    $configId = 'type-' . $type
                        . '-action-' . $action['action_code']
                        . '-tariff-' . $tariff['tariff_code'];

                    $dynamicConfigFields[$configId] = [
                        'id'            => $configId,
                        'type'          => 'multiselect',
                        'sortOrder'     => ($index * 10),
                        'showInDefault' => '1',
                        'showInWebsite' => '0',
                        'showInStore'   => '0',
                        'label'         => __('%1:', $tariff['tariff_name']),
                        'options'       => [
                            'option' => $this->categoryList->toOptionArray(),
                        ],
                        'comment'       => __('Select allowed categories for %1.', $tariff['tariff_name']),
                        '_elementType'  => 'field',
                        'path'          => implode(
                            '/',
                            [
                                static::CONFIG_GENERAL_SECTION_ID,
                                static::GROUP_PATH_PREFIX,
                            ]
                        ),
                    ];
                }

                $dynamicConfigGroups['action-' . $action['action_code']] = [
                    'id'            => 'action-' . $action['action_code'],
                    'label'         => __('%1', $action['action_name']),
                    'showInDefault' => '1',
                    'showInWebsite' => '0',
                    'showInStore'   => '0',
                    'sortOrder'     => ($index * 10),
                    'children'      => $dynamicConfigFields,
                ];
            }
        }

        return $dynamicConfigGroups;
    }

    /**
     * @param OriginalSection $subject
     * @param callable        $proceed
     * @param array           $data
     * @param                 $scope
     *
     * @return mixed
     */
    public function aroundSetData(OriginalSection $subject, callable $proceed, array $data, $scope)
    {
        if ($data['id'] == static::CONFIG_GENERAL_SECTION_ID) {
            if (empty($this->helper->getGeneralConfig('admitad_token'))) {
                if (!$this->admitad->authorizeClient() || $this->done) {
                    return $proceed($data, $scope);
                }
            }

            $dynamicGroups = $this->getDynamicConfigGroups();

            if (!empty($dynamicGroups)) {
                $this->done = true;
                $data['children'] += $dynamicGroups;
            }
        }

        return $proceed($data, $scope);
    }
}
