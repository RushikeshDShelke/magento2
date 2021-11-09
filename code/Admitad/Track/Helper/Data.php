<?php

namespace Admitad\Track\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Config\Storage\WriterInterface;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;
    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $configWriter;

    const XML_PATH_TRACKING = 'admitadtrack/general/';

    const XML_PATH_ACTIONS_TRACKING = 'admitadtrack/actions/';

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        WriterInterface $configWriter
    ) {
        $this->objectManager = $objectManager;
        $this->storeManager = $storeManager;
        $this->configWriter = $configWriter;
        parent::__construct($context);
    }

    public function getConfigValue($field, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $scopeCode
        );
    }

    public function getGeneralConfig($code, $scopeCode = null)
    {
        return $this->getConfigValue(self::XML_PATH_TRACKING . $code, $scopeCode);
    }

    public function setGeneralConfig($code, $value, $scopeId = 0)
    {
        $this->configWriter->save(
            self::XML_PATH_TRACKING . $code,
            $value,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $scopeId
        );
    }
}
