<?php
/**
 * Solwin Infotech
 * Solwin Contact Form Widget Extension
 *
 * @category   Solwin
 * @package    Solwin_Contactwidget
 * @copyright  Copyright © 2006-2016 Solwin (https://www.solwininfotech.com)
 * @license    https://www.solwininfotech.com/magento-extension-license/ 
 */
namespace Solwin\Contactwidget\Controller\Widget;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Area;

class Index extends \Magento\Framework\App\Action\Action
{

    const EMAIL_TEMPLATE = 'contactwidget_section/emailsend/emailtemplate';
    const EMAIL_TEMPLATE_GENERAL_ENQUIRY = 'contactwidget_section/emailsend/emailtemplategeneral';
    const EMAIL_TEMPLATE_ORDER_RELATED = 'contactwidget_section/emailsend/emailtemplateorder';
    const EMAIL_SENDER = 'contactwidget_section/emailsend/emailsenderto';
    const XML_PATH_EMAIL_RECIPIENT = 'contactwidget_section/emailsend/emailto';
    const REQUEST_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const REQUEST_RESPONSE = 'g-recaptcha-response';

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;
    
    /**
     * @var StateInterface
     */
    protected $_inlineTranslation;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     * @var \Solwin\Contactwidget\Helper\Data
     */
    protected $_helper;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $_reader;
    protected $_directoryList;
    private $_email_template;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\Driver\File $reader,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Solwin\Contactwidget\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
        $this->_helper = $helper;
        $this->_storeManager = $storeManager;
        $this->_reader = $reader;
        $this->_directoryList=$directoryList;


    }

    public function execute() {
        $imageFile = null;
        $imageFileDestination=null;
        $error = false;

        $remoteAddr = filter_input(
                INPUT_SERVER,
                'REMOTE_ADDR',
                FILTER_SANITIZE_STRING
                );
        $data = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();
        $redirectUrl = $data['currUrl'];
        $secretkey = $this->_helper
                ->getConfigValue(
                        'contactwidget_section/recaptcha/recaptcha_secretkey'
                        );
        $captchaErrorMsg = $this->_helper
                ->getConfigValue(
                        'contactwidget_section/recaptcha/recaptcha_errormessage'
                        );
        
        if ($data['enablerecaptcha']) {
            if ($captchaErrorMsg == '') {
                $captchaErrorMsg = 'Invalid captcha. Please try again.';
            }
            $captcha = '';
            if (filter_input(INPUT_POST, 'g-recaptcha-response') !== null) {
                $captcha = filter_input(INPUT_POST, 'g-recaptcha-response');
            }

            if (!$captcha) {
                $this->messageManager->addError($captchaErrorMsg);
                return $resultRedirect->setUrl($redirectUrl);
            } else {
                $response = file_get_contents(
                        "https://www.google.com/recaptcha/api/siteverify"
                        . "?secret=" . $secretkey
                        . "&response=" . $captcha
                        . "&remoteip=" . $remoteAddr);
                $response = json_decode($response, true);

                if ($response["success"] === false) {
                    $this->messageManager->addError($captchaErrorMsg);
                    return $resultRedirect->setUrl($redirectUrl);
                }
            }
        }

        try {

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);

            if(trim($data['contact-type'])=='general-enquiry'){
                $this->_email_template=self::EMAIL_TEMPLATE_GENERAL_ENQUIRY;
            }else if(trim($data['contact-type'])=='order-related'){
                $this->_email_template=self::EMAIL_TEMPLATE_ORDER_RELATED;

                //imagefile upload code goes here...
                $imageFile = $_FILES['imageFile'];

                if( $imageFile && $_FILES['imageFile']['error']===0){
                    $imageFileName = $_FILES['imageFile']['name'];
                    $imageFileTmpName = $_FILES['imageFile']['tmp_name'];                   
                    $imageFileSize = $_FILES['imageFile']['size'];

                    $imageFileExt =explode('.', $imageFileName);
                    $imageFileActualExt=strtolower(end($imageFileExt));
                    $allowedExtensions=array('jpg','jpeg','png');

                    if(in_array( $imageFileActualExt,$allowedExtensions)){
                        
                            if( $imageFileSize<2000000){
                                $imageFileNameNew = uniqid('',true) ."." . $imageFileActualExt;
                                $imageFileDestination= $this->_directoryList->getPath('tmp') . "/" . $imageFileNameNew;
                                move_uploaded_file( $imageFileTmpName, $imageFileDestination);

                            }else{
                                $error = true;
                                $this->messageManager->addError("Please upload file less than 2MB.");
                            }
                        
                    }else{
                        $error = true;
                        $this->messageManager->addError("Invalid file format. Allowed file formats are : JPG, PNG");
                    }
                }

            }



            if (!\Zend_Validate::is(trim($data['name']), 'NotEmpty')) {
                $error = true;
            }

            if (!\Zend_Validate::is(trim($data['email']), 'NotEmpty')) {
                $error = true;
            }

            if (!\Zend_Validate::is(trim($data['comment']), 'NotEmpty')) {
                $error = true;
            }


            if ($error) {
                throw new \Exception();
            }

            // send mail to recipients
            $this->_inlineTranslation->suspend();
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;


                 if(trim($data['contact-type'])=='general-enquiry'){
                     $transport = $this->_transportBuilder->setTemplateIdentifier(
                         $this->_scopeConfig->getValue(
                             self::EMAIL_TEMPLATE_GENERAL_ENQUIRY,
                             $storeScope
                         )
                     )->setTemplateOptions(
                         [
                             'area' => Area::AREA_FRONTEND,
                             'store' => $this->_storeManager
                                 ->getStore()
                                 ->getId(),
                         ]
                     )->setTemplateVars(['data' => $postObject])
                         ->setFrom($this->_scopeConfig->getValue(
                             self::EMAIL_SENDER, $storeScope
                         ))
                         ->setReplyTo(trim($data['email']))
                         ->addTo($this->_scopeConfig->getValue(
                             self::XML_PATH_EMAIL_RECIPIENT, $storeScope
                         ))
                         ->getTransport();
                 }else if(trim($data['contact-type'])=='order-related' && $_FILES['imageFile']['error']===0) {
                     $transport = $this->_transportBuilder->setTemplateIdentifier(
                         $this->_scopeConfig->getValue(
                             self::EMAIL_TEMPLATE_ORDER_RELATED,
                             $storeScope
                         )
                     )->setTemplateOptions(
                         [
                             'area' => Area::AREA_FRONTEND,
                             'store' => $this->_storeManager
                                 ->getStore()
                                 ->getId(),
                         ]
                     )->setTemplateVars(['data' => $postObject])
                         ->setFrom($this->_scopeConfig->getValue(
                             self::EMAIL_SENDER, $storeScope
                         ))
                         ->setReplyTo(trim($data['email']))
                         ->addTo($this->_scopeConfig->getValue(
                             self::XML_PATH_EMAIL_RECIPIENT, $storeScope
                         ))
                     ->addAttachment( $this->_reader->fileGetContents($imageFileDestination), \Zend_Mime::TYPE_OCTETSTREAM,\Zend_Mime::DISPOSITION_ATTACHMENT,\Zend_Mime::ENCODING_BASE64,basename( $imageFileDestination))
                         ->getTransport();
                 }else if(trim($data['contact-type'])=='order-related' && $_FILES['imageFile']['error']!==0) {
                     $transport = $this->_transportBuilder->setTemplateIdentifier(
                         $this->_scopeConfig->getValue(
                             self::EMAIL_TEMPLATE_ORDER_RELATED,
                             $storeScope
                         )
                     )->setTemplateOptions(
                         [
                             'area' => Area::AREA_FRONTEND,
                             'store' => $this->_storeManager
                                 ->getStore()
                                 ->getId(),
                         ]
                     )->setTemplateVars(['data' => $postObject])
                         ->setFrom($this->_scopeConfig->getValue(
                             self::EMAIL_SENDER, $storeScope
                         ))
                         ->setReplyTo(trim($data['email']))
                         ->addTo($this->_scopeConfig->getValue(
                             self::XML_PATH_EMAIL_RECIPIENT, $storeScope
                         ))                     
                         ->getTransport();
                 }


            $transport->sendMessage();
            $this->_inlineTranslation->resume();

            $this->messageManager->addSuccess(__('Contact Us request has been '
                    . 'received. We\'ll respond to you very soon.'));
            return $resultRedirect->setUrl($redirectUrl);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_inlineTranslation->resume();
            $this->messageManager->addException($e, __('Something went wrong '
                    . 'while sending the contact us request.'));
        }
        return $resultRedirect->setUrl($redirectUrl);
    }

}
