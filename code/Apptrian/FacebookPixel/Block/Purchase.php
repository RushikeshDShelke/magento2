<?php
/**
 * @category  Apptrian
 * @package   Apptrian_FacebookPixel
 * @author    Apptrian
 * @copyright Copyright (c) 2018 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License
 */

namespace Apptrian\FacebookPixel\Block;

class Purchase extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Apptrian\FacebookPixel\Helper\Data
     */
    public $helper;
    
    /**
     * @var \Magento\Checkout\Model\Session
     */
    public $checkoutSession;
    
    protected $productRepositoryInterface;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Apptrian\FacebookPixel\Helper\Data $helper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Apptrian\FacebookPixel\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        array $data = []
    ) {
        $this->helper          = $helper;
        $this->checkoutSession = $checkoutSession;
        $this->productRepositoryInterface = $productRepositoryInterface;
        parent::__construct($context, $data);
    }
    
    /**
     * Returns data needed for purchase tracking.
     *
     * @return array|null
     */
    public function getOrderData()
    {
        $order   = $this->checkoutSession->getLastRealOrder();
        $orderId = $order->getIncrementId();

        $orderEntityId = $order->getId();  // order entity id
        $orderById = $order->load($orderEntityId); // get data by order id

        if ($orderId) {
            $items = [];
            $configSku = "";  // initialize config sku variable

            foreach ($order->getAllVisibleItems() as $item) {

                if($item->getProductType() == "configurable") //checking only for configurable product
                {
                    // get data by configurable product id
                    $product = $this->productRepositoryInterface->getById($item->getProductId());
                    $configSku = $product->getSku();  // get configurable product sku
                }

                $items[] = [
                    'name' => $item->getName(), 'sku' => $configSku // add configurable sku
                ];
            }
    
            $data = [];
    
            if (count($items) === 1) {
                $data['content_name'] = $this->helper
                    ->escapeSingleQuotes($items[0]['name']);
            }
    
            $ids = '';
            foreach ($items as $i) {
                $ids .= "'" . $this->helper
                    ->escapeSingleQuotes($i['sku']) . "', ";
            }
    
            $data['content_ids']  = trim($ids, ", ");
            $data['content_type'] = 'product';
            $data['value']        = number_format(
                $order->getGrandTotal(),
                2,
                '.',
                ''
            );
            $data['currency']     = $order->getOrderCurrencyCode();
    
            return $data;
        } else {
            return null;
        }
    }
}
