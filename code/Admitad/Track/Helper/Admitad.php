<?php

namespace Admitad\Track\Helper;

use Admitad\Api\Api;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;

class Admitad extends AbstractHelper
{

    const TYPE_INACTIVE = 0;
    const TYPE_SALE = 1;

    const ORDER_TYPE_FIRST_ORDER = 1;
    const ORDER_TYPE_SECOND_ORDER = 2;

    /**
     * The affiliate cookie name
     */
    const COOKIE_NAME = "_aid";

    /**
     * @var \Magento\Framework\ObjectManagerInterface objectManager
     */
    private $objectManager;
    /**
     * @var \Admitad\Track\Helper\Data helper
     */
    private $helper;
    /**
     * @var Api api
     */
    private $api;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        Data $helper
    ) {
        $this->objectManager = $objectManager;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function authorizeClient()
    {
        $api = new Api();

        try {
            $response = $api->authorizeClient(
                $this->helper->getGeneralConfig('client_id'),
                $this->helper->getGeneralConfig('client_secret'),
                'advertiser_info'
            );
            $data = $response->getArrayResult();
        } catch (\Exception $e) {
            return false;
        }

        if (!empty($data['access_token']) and !empty($data['refresh_token']) and !empty($data['expires_in'])) {
            $this->helper->setGeneralConfig('admitad_token', $data['access_token']);
            $this->helper->setGeneralConfig('admitad_refresh_token', $data['refresh_token']);
            $this->helper->setGeneralConfig('admitad_token_expires_in', (time() + $data['expires_in']));

            return true;
        } else {
            return false;
        }
    }

    public function getAdvertiserInfo($token = null)
    {
        try {
            $result = $this->getApi($token);
            $result = $result->get('/advertiser/info/');
            $data = $result->getArrayResult()[0];
        } catch (\Exception $e) {
            return [];
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->helper->getGeneralConfig('admitad_token_expires_in') <= time();
    }

    /**
     * @param $token
     *
     * @return Api
     */
    public function getApi($token = null)
    {
        if ($token) {
            $this->api = new Api($token);
        } else {
            $this->api = new Api($this->helper->getGeneralConfig('admitad_token'));
        }
        if ($this->isExpired()) {
            $response = $this->api->refreshToken(
                $this->helper->getGeneralConfig('client_id'),
                $this->helper->getGeneralConfig('client_secret'),
                $this->helper->getGeneralConfig('admitad_refresh_token')
            );
            $data = $response->getArrayResult();

            $this->helper->setGeneralConfig('admitad_refresh_token', $data['refresh_token']);
            $this->helper->setGeneralConfig('admitad_token_expires_in', time() + $data['expires_in']);
        }

        return $this->api;
    }

    public static function getAvailableTypes()
    {
        return [
            static::TYPE_INACTIVE => [
                'value' => static::TYPE_INACTIVE,
                'label' => __('Inactive'),
            ],
            static::TYPE_SALE     => [
                'value' => static::TYPE_SALE,
                'label' => __('Sale'),
            ],
        ];
    }

    public static function getOrderTypes()
    {
        $types = [
            static::ORDER_TYPE_FIRST_ORDER => __('First order'),
        ];

        return $types;
    }

    public static function getTariffData($productId)
    {
        $configuration = static::getConfiguration();
        $sections = static::getCategoryCollection($productId);
        $defaultData = [];
        $configuration = static::getOrderType($configuration);
        foreach ($configuration as $actionCode => $actionData) {
            if (!$actionData['type']) {
                continue;
            }

            foreach ($actionData['tariffs'] as $tariffCode => $data) {
                if (!empty($data['all']) and $data['all'] == 'Y') {
                    return [
                        'action_code' => $actionCode,
                        'tariff_code' => $tariffCode,
                    ];
                }

                if (empty($defaultData) && !empty($data['categories'])) {
                    $defaultData = [
                        'action_code' => $actionCode,
                        'tariff_code' => $tariffCode,
                    ];
                }

                $tariffSections = array_values($data['categories']);

                if (array_intersect($sections, $tariffSections)) {
                    return [
                        'action_code' => $actionCode,
                        'tariff_code' => $tariffCode,
                    ];
                }
            }
        }

        return $defaultData;
    }

    /**
     * @return array
     */
    public static function getConfiguration()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Admitad\Track\Helper\Data $helper */
        $helper = $objectManager->get('\Admitad\Track\Helper\Data');

        $actions = $helper->getConfigValue('admitadtrack/actions');

        $result = [];

        foreach ($actions as $action => $value) {
            if (preg_match('/^type-(?<type>[0-9]*)-action-(?<action>[a-zA-Z0-9]*)$/', $action, $matches)) {
                $result[$matches['type']][$matches['action']]['type'] = $value;
            }
            if (preg_match('/^type-(?<type>[0-9]*)-action-(?<action>[a-zA-Z0-9]*)-tariff-(?<tariff>[0-9]*)$/', $action, $matches)) {
                $result[$matches['type']][$matches['action']]['tariffs'][$matches['tariff']]['categories'] = explode(',', $value);
            }
        }

        return $result;
    }

    public static function getOrderType($configuration)
    {
        return $configuration[static::ORDER_TYPE_FIRST_ORDER];
    }

    public static function getCategoryCollection($productId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        /** @var \Magento\Catalog\Model\Product\Interceptor $product */
        $product = $productRepository->getById($productId);

        return $product->getCategoryIds();
    }

    public static function admitadPostback($campaignCode, $postbackKey, $orderId, array $positions, array $parameters = [], $uid = null)
    {

        $positions = array_values($positions);

        if (!$uid) {
            return;
        }

        $defaults = [
            'payment_type' => 'sale',
            'tariff_code'  => 1,
        ];

        $global = array_merge([
            'campaign_code' => $campaignCode,
            'postback'      => true,
            'postback_key'  => $postbackKey,
            'response_type' => 'img',
            'action_code'   => 1,
            'adm_method' => 'plugin',
            'adm_method_name' => 'magento2',
            'channel' => 'adm',
        ], $parameters);

        $admitadPositions = static::generateAdmitadPositions($uid, $orderId, $positions, array_merge($global, $defaults));

        foreach ($admitadPositions as $position) {
            $parts = [];
            foreach ($position as $key => $value) {
                $parts[] = $key . '=' . urlencode($value);
            }


            $url = 'https://ad.admitad.com/tt?' . implode('&', $parts);

            if (!function_exists('curl_init')) {
                file_get_contents($url);
                continue;
            }

            $cl = curl_init($url);

            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);

            curl_exec($cl);
        }
    }

    public static function generateAdmitadPositions($uid, $orderId, array $positions, array $parameters = [])
    {
        $config = array_merge([
            'uid'            => $uid,
            'order_id'       => $orderId,
            'position_count' => count($positions),
        ], $parameters);

        foreach ($positions as $index => &$position) {
            $position = array_merge($config, [
                'position_id' => $index + 1,
            ], $position);
        }

        return $positions;
    }
}
