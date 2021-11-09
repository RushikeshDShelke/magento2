<?php

namespace M2s\Vouchagram\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class InstallData implements InstallDataInterface
{

    protected $_salesSetupFactory;
    protected $_quoteSetupFactory;

    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->_salesSetupFactory = $salesSetupFactory;
        $this->_quoteSetupFactory = $quoteSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        
        $salesInstaller = $this->_salesSetupFactory
                        ->create(
                            [
                                'resourceName' => 'sales_setup',
                                'setup' => $setup
                            ]
                        );
        $quoteInstaller = $this->_quoteSetupFactory
                        ->create(
                            [
                                'resourceName' => 'quote_setup',
                                'setup' => $setup
                            ]
                        );

        $this->addQuoteAttributes($quoteInstaller);
        $this->addOrderAttributes($salesInstaller);

        $installer = $setup;

        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('vouchagram'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'coupon_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'coupon_code'
            )->addColumn(
                'quote_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'quote_id'
            )->addColumn(
                'quote_value',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                "10,2",
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'quote_value'
            );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();

    }

    /**
     * add attribute in quote address
     * @param object $installer
     */
    public function addQuoteAttributes($installer)
    {
        $installer->addAttribute('quote_address', 'coupondiscount_total', ['type' => 'text']);
        $installer->addAttribute('quote_address', 'coupondiscount_code', ['type' => 'text']);
    }

    /**
     * add attribute in sales_order
     * @param object $installer
     */
    public function addOrderAttributes($installer)
    {
        $installer->addAttribute('order', 'coupondiscount_total', ['type' => 'text']);
        $installer->addAttribute('order', 'coupondiscount_code', ['type' => 'text']);
    }
}
