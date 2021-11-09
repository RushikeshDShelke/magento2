<?php

namespace Tagalys\Customizations\Observer;

class ReadProductDetails implements \Magento\Framework\Event\ObserverInterface
{
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    $productDetailsObj = $observer->getData('tgls_data');
    $productDetails = $productDetailsObj->getProductDetails();
    
    // modify $productDetails
    
    $productDetailsObj->setProductDetails($productDetails);

    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/checking_tagalys.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info("obeserver called-----------ReadProductDetails.php");
    return $this;
  }
}
