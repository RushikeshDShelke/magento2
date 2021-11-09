<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create Yosto Arp Rule table
         */

        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule'))
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Id'
            )
            ->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Is Active'
            )
            ->addColumn(
                'block_position',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Block position'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Name'
            )

            ->addColumn(
                'where_conditions_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                [],
                'Where Conditions Serialized'
            )
            ->addColumn(
                'what_conditions_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                [],
                'What Conditions Serialized'
            )
            ->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Priority'
            )
            ->addColumn(
                'block_title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Block title'
            )
            ->addColumn(
                'layout',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Block Layout'
            )
            ->addColumn(
                'show_cart_button',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Show Cart Button'
            )
            ->addColumn(
                'max_products',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Max Products'
            )
            ->addColumn(
                'sort_by',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Sort By'
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule', ['is_active', 'sort_order']),
                ['is_active', 'sort_order']
            )
            ->setComment('Auto Related Products Rule');

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'yosto_arp_rule_group_website'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule_group_website'))
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true, 'default' => '0'],
                'Rule Id'
            )
            ->addColumn(
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true, 'default' => '0'],
                'Customer Group Id'
            )
            ->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true, 'default' => '0'],
                'Website Id'
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_group_website', ['customer_group_id']),
                ['customer_group_id']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_group_website', ['website_id']),
                ['website_id']
            )
            ->addForeignKey(
                $installer->getFkName(
                    'yosto_arp_rule_group_website',
                    'customer_group_id',
                    'customer_group',
                    'customer_group_id'
                ),
                'customer_group_id',
                $installer->getTable('customer_group'),
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('yosto_arp_rule_group_website', 'rule_id', 'yosto_arp_rule', 'rule_id'),
                'rule_id',
                $installer->getTable('yosto_arp_rule'),
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('yosto_arp_rule_group_website', 'website_id', 'store_website', 'website_id'),
                'website_id',
                $installer->getTable('store_website'),
                'website_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Arp Rule Group Website');

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'yosto_arp_rule_website'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule_website'))
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Id'
            )
            ->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Website Id'
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_website', ['website_id']),
                ['website_id']
            )
            ->addForeignKey(
                $installer->getFkName('yosto_arp_rule_website', 'rule_id', 'yosto_arp_rule', 'rule_id'),
                'rule_id',
                $installer->getTable('yosto_arp_rule'),
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('yosto_arp_rule_website', 'website_id', 'store_website', 'website_id'),
                'website_id',
                $installer->getTable('store_website'),
                'website_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Arp Rules To Websites Relations');

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'yosto_arp_rule_customer_group'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule_customer_group'))
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Id'
            )
            ->addColumn(
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Customer Group Id'
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_customer_group', ['customer_group_id']),
                ['customer_group_id']
            )
            ->addForeignKey(
                $installer->getFkName('yosto_arp_rule_customer_group', 'rule_id', 'yosto_arp_rule', 'rule_id'),
                'rule_id',
                $installer->getTable('yosto_arp_rule'),
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    'yosto_arp_rule_customer_group',
                    'customer_group_id',
                    'customer_group',
                    'customer_group_id'
                ),
                'customer_group_id',
                $installer->getTable('customer_group'),
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Arp Rules To Customer Groups Relations');

        $installer->getConnection()->createTable($table);
        /**
         * Create table 'yosto_arp_rule_where_product'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule_where_product'))
            ->addColumn(
                'rule_product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Product Id'
            )
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Rule Id'
            )
            ->addColumn(
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Customer Group Id'
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Product Id'
            )

            ->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Sort Order'
            )
            ->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Website Id'
            )
            ->addColumn(
                'block_position',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Block position'
            )
            ->addIndex(
                $installer->getIdxName(
                    'yosto_arp_rule_where_product',
                    ['rule_id', 'website_id', 'customer_group_id', 'product_id', 'sort_order', 'block_position'],
                    true
                ),
                ['rule_id', 'website_id', 'customer_group_id', 'product_id', 'sort_order', 'block_position'],
                ['type' => 'unique']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_where_product', ['customer_group_id']),
                ['customer_group_id']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_where_product', ['website_id']),
                ['website_id']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_where_product', ['product_id']),
                ['product_id']
            )
            ->setComment('Match Product with Where condition');
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'yosto_arp_rule_what_product'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yosto_arp_rule_what_product'))
            ->addColumn(
                'rule_product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Product Id'
            )
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Rule Id'
            )
            ->addColumn(
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Customer Group Id'
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Product Id'
            )
            ->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Sort Order'
            )
            ->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Website Id'
            )
            ->addColumn(
                'block_position',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Block position'
            )
            ->addIndex(
                $installer->getIdxName(
                    'yosto_arp_rule_what_product',
                    ['rule_id', 'website_id', 'customer_group_id', 'product_id', 'sort_order', 'block_position'],
                    true
                ),
                ['rule_id', 'website_id', 'customer_group_id', 'product_id', 'sort_order', 'block_position'],
                ['type' => 'unique']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_what_product', ['customer_group_id']),
                ['customer_group_id']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_what_product', ['website_id']),
                ['website_id']
            )
            ->addIndex(
                $installer->getIdxName('yosto_arp_rule_what_product', ['product_id']),
                ['product_id']
            )
            ->setComment('Match Product with What condition');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}