<?php 
namespace Magecomp\Codverification\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ObjectManager;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SMSGATEWAY ='codverification/smsgatways/gateway';

    protected $smsgatewaylist;

	public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                array $smsgatewaylist = [])
	{
        $this->smsgatewaylist = $smsgatewaylist;
		parent::__construct($context);
	}

    public function getSmsgatewaylist()
    {
        return $this->smsgatewaylist;
    }

    public function getSelectedGateway() {
        return $this->scopeConfig->getValue(self::XML_PATH_SMSGATEWAY,
            ScopeInterface::SCOPE_STORE);
    }

    public function getSelectedGatewayModel()
    {
        if($this->getSelectedGateway() != '' || $this->getSelectedGateway() != null)
        {
            $Selectedgateway = $this->smsgatewaylist[$this->getSelectedGateway()];
            return ObjectManager::getInstance()->create($Selectedgateway);
        }
        else
            return null;
    }
	
	public function callApiUrl($mobilenumbers,$message)
	{
        $curentsmsModel = $this->getSelectedGatewayModel();

        if($curentsmsModel == '' || $curentsmsModel == null){
            return __("SMS Gateway haven't configured yet.");
        }

        if(!$curentsmsModel->validateSmsConfig()){
            return __("Please, Make Sure You have Configured SMS Gateway Properly.");
        }

        return $curentsmsModel->callApiUrl($mobilenumbers,$message);
	}
}