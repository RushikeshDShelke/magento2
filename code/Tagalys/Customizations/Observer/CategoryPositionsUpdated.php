<?php

namespace Tagalys\Customizations\Observer;

class CategoryPositionsUpdated implements \Magento\Framework\Event\ObserverInterface
{
  protected $_categoryFactory;

  public function __construct(
    \Magento\Catalog\Model\CategoryFactory $categoryFactory
  ){
    $this->_categoryFactory = $categoryFactory;
  }
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/new_taglyst_cat_update.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);

    $categoryIdObj = $observer->getData('tgls_data');
    $categoryId = $categoryIdObj->getCategoryId();

    $logger->info("==============start observer================");

    /* 
      For single url flush
      Need to change ip,port,secret file path & host if move this code into another server
    */

    // $categoryId = array(20,134);
    // foreach ($categoryId as $id) {
    //   $category = $this->_categoryFactory->create()->load($id);
    //   $catFullUrl = $category->getUrl(); /* get full category url */
    //   $splitUrl = parse_url($catFullUrl, PHP_URL_PATH); /* split url */
      
      // $shellScript = shell_exec('
      //   varnishadm -T 172.16.102.173:6082 -S /home/shopcrocs/secret ban "req.http.host == shopcrocs.in && req.url == "'.$splitUrl.'');


    //     try {
    //       $logger->info("Varnish is successfully flushed for url => ".$splitUrl);
    //     } catch (Exception $e) {
    //       $logger->info($e->getMessage()." ".$shellScript);
    //     }
    // }


    /* 
      For Full flush
      Need to change ip,port,secret file path & host if move this code into another server
    */
    $shellScript = shell_exec('
        varnishadm -T 172.16.102.173:6082 -S /home/shopcrocs/secret ban "req.http.host == shopcrocs.in"');
    try {
      $logger->info("Varnish is successfully flushed for url");
    } catch (Exception $e) {
      $logger->info($e->getMessage()." ".$shellScript);
    }
    $logger->info("==============end observer================");

    return $this;
  }
}
