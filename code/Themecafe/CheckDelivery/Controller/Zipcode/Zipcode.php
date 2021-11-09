<?php
namespace Themecafe\CheckDelivery\Controller\Zipcode;

use Magento\Framework\Controller\Result\JsonFactory as JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfigInterface;

class Zipcode extends \Magento\Framework\App\Action\Action
{

    protected $messageManager;
    protected $helper;
    protected $resultJsonFactory;
    protected $customerSession;
    protected $pindata;
    protected $success;
    protected $failure;
    protected $request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Themecafe\CheckDelivery\Helper\Data $helper, 
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig
    ) 
    {
        $this->messageManager = $context->getMessageManager();
        $this->request = $context->getRequest();
        $this->helper = $helper;

        $this->resultJsonFactory = $jsonFactory;
        $this->customerSession = $context->getObjectManager()->get('Magento\Customer\Model\Session');
        $this->scopeConfig = $scopeConfig;

        $this->success = $this->helper->getConfig('check_delivery/general/product_page_success_message');
        $this->failure = $this->helper->getConfig('check_delivery/general/product_page_failure_message');
        $this->_productLevel = $this->helper->getConfig('check_delivery/general/product_level/product_level_active');
        $this->_productIds = $this->helper->getConfig('check_delivery/general/product_level/product_ids');
        $this->scopeWebsite = \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $zip = $data['zipcode'];
            if (isset($data['product_id'])) {
                $productid = $data['product_id'];
            }

            $productiddata = explode(',', $this->_productIds);
            $productids = array_map('trim', $productiddata);

            $this->pindata = $this->helper->getConfig('check_delivery/general/zip_code');
            $CODpindata = $this->helper->getConfig('check_delivery/cod_restriction/zip_code');
            $CODstatus = $this->helper->getConfig('check_delivery/cod_restriction/active');

            $CODsuccess = $this->helper->getConfig('check_delivery/cod_restriction/success_message');
            $CODfailure = $this->helper->getConfig('check_delivery/cod_restriction/failure_message');

            $CODPaymentstatus = $this->scopeConfig->getValue('payment/cashondelivery/active', $this->scopeWebsite);

            $trimedZip = strtolower(trim($zip));

            $this->pindata = trim($this->pindata);

            if ($zip == "") {
                $response['requierdmessage'] = "This is required field";
                $this->customerSession->setTssZipCode("");
                return $this->resultJsonFactory->create()->setData($response);
            } elseif ($this->pindata == "") {
                $response['message'] = "<div class='message-success success message'><div>" ;
                $response['message'] .= $this->success . "</div></div>";
                if ($CODstatus && $CODPaymentstatus) {
                    $response['CODmessage'] = $this->codRestriction($CODpindata, $trimedZip, $CODsuccess, $CODfailure);
                }
                $this->customerSession->setTssZipCode($zip);
                return $this->resultJsonFactory->create()->setData($response);
            }

            $pincode = explode(",", $this->pindata);
            $pincodearraytrim = array_map('trim', $pincode);
            $pincodearray = array_map('strtolower', $pincodearraytrim);
            $response = [];
            if ($this->_productLevel) {
                if (in_array($productid, $productids)) {
                    if (in_array($trimedZip, $pincodearray)) {
                        $response['message'] = "<div class='message-success success message'><div>" ;
                        $response['message'] .= $this->success . "</div></div>";
                        if ($CODstatus && $CODPaymentstatus) {
                            $response['CODmessage'] = $this->codRestriction(
                                                                $CODpindata,
                                                                $trimedZip,
                                                                $CODsuccess,
                                                                $CODfailure);
                        }
                        $this->customerSession->setTssZipCode($zip);
                    } else {
                        $response['message'] = "<div class='message-success error message'><div>" ;
                        $response['message'] .= $this->failure . "</div></div>";
                        $this->customerSession->setTssZipCode("");
                    }
                } else {
                    $response['message'] = "<div class='message-success success message'><div>" ;
                    $response['message'] .= $this->success . "</div></div>";
                    if ($CODstatus && $CODPaymentstatus) {
                        $response['CODmessage'] = $this->codRestriction(
                                                            $CODpindata,
                                                            $trimedZip,
                                                            $CODsuccess,
                                                            $CODfailure);
                    }
                    $this->customerSession->setTssZipCode($zip);
                }
            } else {
                if (in_array($trimedZip, $pincodearray)) {
                    $response['message'] = "<div class='message-success success message'><div>" ;
                    $response['message'] .= $this->success . "</div></div>";
                    if ($CODstatus && $CODPaymentstatus) {
                        $response['CODmessage'] = $this->codRestriction(
                                                            $CODpindata,
                                                            $trimedZip,
                                                            $CODsuccess,
                                                            $CODfailure);
                    }
                    $this->customerSession->setTssZipCode($zip);
                } else {
                    $response['message'] = "<div class='message-success error message'><div>" ;
                        $response['message'] .= $this->failure . "</div></div>";
                    $this->customerSession->setTssZipCode("");
                }
            }

            return $this->resultJsonFactory->create()->setData($response);
        } else {
            $this->messageManager->addError(__('Something went wrong!'));
        }
    }

    public function codRestriction($CODpins, $zipcode, $CODsuccess, $CODfailure)
    {
        $CODpinsarray = array_map('trim', explode(',', $CODpins));
        $CODpindata = array_map('strtolower', $CODpinsarray);
        if (in_array($zipcode, $CODpindata) || trim($CODpins) == "") {
            return "<div class='message-success success message'><div>" . $CODsuccess . "</div></div>";
        } else {
            return "<div class='message-success error message'><div>" . $CODfailure . "</div></div>";
        }
    }

}
