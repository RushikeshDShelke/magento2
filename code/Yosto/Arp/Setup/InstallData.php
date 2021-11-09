<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Arp\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup->createMigrationSetup();
        $setup->startSetup();
        
        $installer->appendClassAliasReplace(
            'yosto_arp_rule',
            'where_conditions_serialized',
            \Magento\Framework\Module\Setup\Migration::ENTITY_TYPE_MODEL,
            \Magento\Framework\Module\Setup\Migration::FIELD_CONTENT_TYPE_SERIALIZED,
            ['rule_id']
        );
        $installer->appendClassAliasReplace(
            'yosto_arp_rule',
            'what_conditions_serialized',
            \Magento\Framework\Module\Setup\Migration::ENTITY_TYPE_MODEL,
            \Magento\Framework\Module\Setup\Migration::FIELD_CONTENT_TYPE_SERIALIZED,
            ['rule_id']
        );
        
        $installer->doUpdateClassAliases();

        $setup->endSetup();
        
    }
}
