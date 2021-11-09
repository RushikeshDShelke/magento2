<?php
namespace Invanos\Ajaxproduct\Controller\Index;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{  
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		\Magento\Framework\View\LayoutFactory $layoutFactory
	)
	{        
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->layoutFactory = $layoutFactory;    
	}    
	public function execute()    
	{
		$result = $this->resultJsonFactory->create();
		$resultPage = $this->resultPageFactory->create();
		// $productId = $this->getRequest()->getParam('productId');
		// echo $productId;exit();
		// $renderer = $this->layoutFactory->create()->createBlock('Magento\Catalog\Block\Product\View\Description')->setTemplate('Magento_Catalog::product/view/newDetails.phtml')->toHtml();
		// $response = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
		// $layout = $response->addHandle('catalog_product_view')->getLayout();
		// $renderer = $layout->getBlock('product.info.details')->toHtml();
		// return $result->setData(['html' => $renderer]);   

		// $block = $resultPage->getLayout()
  //               ->createBlock('Magento\Catalog\Block\Product\View\Description')
  //               ->setTemplate('Magento_Catalog::product/view/newDetails.phtml')
  //               ->toHtml();
        return $resultPage;
	}
}




// namespace Invanos\Ajaxproduct\Controller\Index;

// class Index extends \Magento\Framework\App\Action\Action
// {
// 	protected $_pageFactory;

// 	public function __construct(
// 		\Magento\Framework\App\Action\Context $context,
// 		\Magento\Framework\View\Result\PageFactory $pageFactory)
// 	{
// 		$this->_pageFactory = $pageFactory;
// 		return parent::__construct($context);
// 	}

// 	public function execute()
// 	{
// 		$resultPage = $this->_pageFactory->create();
// 		// echo ",,,,,,,sssw";
// 		$block = $resultPage->getLayout()->createBlock('Magento\Catalog\Block\Product\View\Description')->setTemplate('Magento_Catalog::product/view/newDetails.phtml')->toHtml();
//         // $response = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//         // $layout = $response->addHandle('catalog_product_view')->getLayout();
//         // $renderer = $layout->getBlock('product.info.details')->toHtml();

//         return $result->setData(['html' => $block]);
//         // return $this->getResponse()->setBody($block);
// 	}
// }