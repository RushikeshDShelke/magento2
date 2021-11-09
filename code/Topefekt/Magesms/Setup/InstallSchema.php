<?php
/**
 * Mage SMS - SMS notification & SMS marketing
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the BSD 3-Clause License
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/BSD-3-Clause
 *
 * @category    TOPefekt
 * @package     TOPefekt_Magesms
 * @copyright   Copyright (c) 2012-2017 TOPefekt s.r.o. (http://www.mage-sms.com)
 * @license     http://opensource.org/licenses/BSD-3-Clause
 */
namespace Topefekt\Magesms\Setup; use Magento\Framework\Setup\InstallSchemaInterface; use Magento\Framework\Setup\ModuleContextInterface; use Magento\Framework\Setup\SchemaSetupInterface; use Magento\Framework\DB\Ddl\Table; class InstallSchema implements InstallSchemaInterface { public function install(SchemaSetupInterface $iae3e2ffb6c51b544cd0688f6a7936cf83969b8a9, ModuleContextInterface $i31cc913adc2717e2346d503153c97449098831aa) { $iddb18dc4afa6663cf07a52c741943ff87cbe3896 = $iae3e2ffb6c51b544cd0688f6a7936cf83969b8a9; $iddb18dc4afa6663cf07a52c741943ff87cbe3896->startSetup(); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_admins')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`number` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_answers')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`text` text NOT NULL,
	`from` varchar(50) NOT NULL DEFAULT '',
	`prohlednuto` tinyint(3) NOT NULL DEFAULT '0',
	`smsc` varchar(100) NOT NULL DEFAULT '',
	`cas` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_birthdaymessages_template')}` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `run_time` time NOT NULL,
  `delay` tinyint(4) NOT NULL DEFAULT '0',
  `smstext` text NOT NULL,
  `active` tinyint(3) NOT NULL,
  `mutation` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_country')} (
	`name` varchar(100) NOT NULL,
	`vat` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`currency` varchar(3) NOT NULL,
	`area` int(11) NOT NULL,
	PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_country_lang')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`country_name` varchar(100) NOT NULL,
	`lang` varchar(10) NOT NULL,
	`iso_2` varchar(2) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `country_name` (`country_name`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_exceptions')}` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`prefix` int(11) NOT NULL,
	`first_prefix` int(11) NOT NULL,
	`length` tinyint(4) NOT NULL,
	`trim` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_hooks')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) CHARACTER SET utf8 NOT NULL,
	`info` text NOT NULL,
	`status` tinyint(3) NOT NULL,
	`owner` tinyint(3) NOT NULL,
	`group_type` tinyint(3) NOT NULL,
	`template` text NOT NULL,
	`template_customer` text NOT NULL,
	`notice` text NOT NULL,
	`lang` varchar(10) NOT NULL,
	`system` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_hooks_admins')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`smstext` text NOT NULL,
	`admin_id` int(11) NOT NULL,
	`store_group_id` smallint(5) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uniq` (`name`,`admin_id`,`store_group_id`),
	KEY `store_group_id` (`store_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_hooks_customers')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`smstext` text NOT NULL,
	`active` tinyint(3) NOT NULL,
	`mutation` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_hooks_templates')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`area` varchar(10) NOT NULL,
	`area_text` varchar(100) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `area` (`area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_hooks_unicode')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`area` varchar(10) NOT NULL,
	`unicode` tinyint(3) NOT NULL,
	`type` varchar(10) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `area` (`area`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_maps')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`area` int(10) NOT NULL,
	`number` int(5) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_marketing_filter')}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `filter` text,
  `disabled` text,
  `disabled_counter` tinyint(4) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
	CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_optout_order')}` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`order_id` int(10) unsigned NOT NULL,
	`disabled` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_ownnumbersender')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`val` varchar(30) NOT NULL,
	PRIMARY KEY `id` (`id`),
	UNIQUE KEY `val` (`val`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_routes')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`area` int(5) NOT NULL,
	`type` varchar(20) NOT NULL,
	`isms` int(5) NOT NULL,
	`sendertype` tinyint(3) NOT NULL,
	`sender_id` varchar(30) NOT NULL,
	`info` text NOT NULL,
	`area_text` varchar(50) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique` (`area_text`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_routes_alternative')}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `route_id` int(10) unsigned NOT NULL,
  `store_group_id` smallint(5) unsigned NOT NULL,
  `textsender` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alternative_unique` (`route_id`,`store_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_smshistory')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`number` varchar(30) NOT NULL,
	`date` datetime NOT NULL,
	`text` text NOT NULL,
	`status` tinyint(3) NOT NULL,
	`price` double(5,3) NOT NULL,
	`credit` double(15,3) NOT NULL,
	`sender` varchar(30) NOT NULL,
	`unicode` tinyint(1) NOT NULL,
	`type` tinyint(3) NOT NULL,
	`smsid` varchar(250) NOT NULL,
	`note` varchar(100) NOT NULL,
	`total` tinyint(3) NOT NULL,
	`admin_id` int(10) unsigned DEFAULT NULL,
	`customer_id` int(10) unsigned DEFAULT NULL,
	`recipient` varchar(100) NOT NULL,
	`subject` varchar(100) NOT NULL,
	`change` tinyint(4) NOT NULL DEFAULT '1',
	`campaign_id` int(10) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `vyber1` (`date`),
	KEY `vyber2` (`date`,`type`),
	KEY `vyber3` (`date`,`type`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_smsuser')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user` varchar(55) NOT NULL,
	`passwd` varchar(55) NOT NULL,
	`email` varchar(100) NOT NULL,
	`regtype` varchar(10) NOT NULL,
	`companyname` varchar(100) NOT NULL,
	`addressstreet` varchar(100) NOT NULL,
	`addresscity` varchar(100) NOT NULL,
	`addresszip` varchar(100) NOT NULL,
	`country` varchar(100) NOT NULL,
	`companyid` varchar(100) NOT NULL,
	`companyvat` varchar(100) NOT NULL,
	`simulatesms` tinyint(1) NOT NULL,
	`deletedb` tinyint(1) NOT NULL,
	`credit` int(6) NOT NULL,
	`delivery_email` varchar(100) NOT NULL,
	`url_reports` tinyint(1) NOT NULL,
	`prefbilling` tinyint(1) NOT NULL,
	`delivery_reports_error_only` tinyint(1) NOT NULL,
	`firstname` varchar(50) NOT NULL,
	`lastname` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS `{$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_template')}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `template` text,
  `unicode` tinyint(1) NOT NULL DEFAULT '0',
  `unique` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_textsender')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`val` varchar(11) NOT NULL,
	PRIMARY KEY `id` (`id`),
	UNIQUE KEY `val` (`val`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); $iddb18dc4afa6663cf07a52c741943ff87cbe3896->run("
CREATE TABLE IF NOT EXISTS {$iddb18dc4afa6663cf07a52c741943ff87cbe3896->getTable('magesms_variables')} (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(200) NOT NULL,
	`template` text NOT NULL,
	`translate` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); } } 