<?php

namespace Invanos\Conditionalpixel\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory CookieMetadataFactory
     */
    private $cookieMetadataFactory;
    protected $request;

    /**
     * Conditional Pixel Block
     *
     * @var \Invanos\Conditionalpixel\Block\Cookiedata
     */
    public $cookieData;

    public function __construct(
    	\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Request\Http $request,
        \Invanos\Conditionalpixel\Block\Cookiedata $cookieData
    ) {
    	parent::__construct($context);
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_request = $request;
        $this->_cookieData = $cookieData;
    }

	public function execute()
	{
        $status = '';
        try
        {
            // checking module status from admin
            $moduleStatus = $this->_cookieData->isEnabled();

            if ($moduleStatus == 1)
            {
                $resultJson = $this->_resultJsonFactory->create();
                $requestUrl = $this->_request->getParam('url'); // getting url value from ajax request
                
                // setting cookie duration from admin
                $cookieDuration = $this->_cookieData->getCookieDurations();

                $publicCookieMetadata = $this->_cookieMetadataFactory->createPublicCookieMetadata();
                $publicCookieMetadata->setDuration($cookieDuration);
                $publicCookieMetadata->setPath('/');
                $publicCookieMetadata->setHttpOnly(false);
         
                $UTMurl = $this->_cookieManager->getCookie('utm_para'); //checking cookie

                if (!isset($UTMurl))
                {
                    // set cookie
                    $this->_cookieManager->setPublicCookie(
                        'utm_para',
                        $requestUrl,
                        $publicCookieMetadata
                    );
                    $status = "cookie added successfully";
                }
                else
                {
                    $status = "cookie already exist";
                }
            }
            else
            {
                $status = "module is disable";
            }
        }
        catch (Exception $e)
        {
            $status = $e->getMessage();
        }
        
        return $resultJson->setData([
            'success' => $status
        ]);
	}
}