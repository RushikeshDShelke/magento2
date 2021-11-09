<?php
namespace Themecafe\CCAvenue\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class CcavenueConfigProvider implements ConfigProviderInterface
{
    protected  $storeManager;
    public function __construct(
    \Magento\Store\Model\StoreManager $storeManager,
    \Themecafe\CCAvenue\Model\Config $ccAvenueConfig
    ) {
       
        $this->storeManager = $storeManager;
        $this->ccAvenueConfig = $ccAvenueConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        //echo $option = $this->getIntegrationTechnique();die;
        $config = [
            'payment' => [
                'ccavenue' => [
                    'redirectUrl' => $this->getRedirectUrl(),
 		    'integrationType' => $this->ccAvenueConfig->getIntegrationTechnique(),
                ]
            ]
        ];
        return $config;
    }
    public function getIntegrationTechniqueUrl() {
        if($this->ccAvenueConfig->getIntegrationTechnique() == 'redirect')
        {
            return $this->ccAvenueConfig->getGatewayUrl(); 
        }
        else
        {
           return $this->getRedirectUrl();
        }
    }
    
    public function getRedirectUrl() {
        return $this->storeManager->getStore()->getUrl('ccavenue/ccavenue/redirect');
    }
    
    
    /**
     * Retrieve request object
     *
     * @return \Magento\Framework\App\RequestInterface
     */
    protected function _getRequest()
    {
        return $this->_request;
    }
    
}
