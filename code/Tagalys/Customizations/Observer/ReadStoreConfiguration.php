<?php

namespace Tagalys\Customizations\Observer;

class ReadStoreConfiguration implements \Magento\Framework\Event\ObserverInterface
{
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    $configurationObj = $observer->getData('tgls_data');
    $configuration = $configurationObj->getConfiguration();

    // modify $configuration

    $configurationObj->setConfiguration($configuration);

    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/checking_tagalys.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info("obeserver called-------------------------ReadStoreConfiguration.php");

    return $this;
  }
}
