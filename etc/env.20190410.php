<?php
return array (
  'cache_types' => 
  array (
    'compiled_config' => 1,
    'config' => 1,
    'layout' => 1,
    'block_html' => 1,
    'collections' => 1,
    'reflection' => 1,
    'db_ddl' => 1,
    'eav' => 1,
    'customer_notification' => 1,
    'full_page' => 1,
    'config_integration' => 1,
    'config_integration_api' => 1,
    'translate' => 1,
    'config_webservice' => 1,
    'wp_gtm_categories' => 1,
  ),
  'backend' => 
  array (
    'frontName' => 'superman',
  ),
  'crypt' => 
  array (
    'key' => '53d06f6fda785e88718fee0fd62d7efa',
  ),
  'db' => 
  array (
    'table_prefix' => '',
    'connection' => 
    array (
      'default' => 
      array (
        'host' => '127.0.0.1',
        'dbname' => 'a139e831_crocsoct',
        'username' => 'a139e831_crocsoc',
        'password' => 'DinNuzzleFliersAssize50',
        'active' => '1',
        'model' => 'mysql4',
        'engine' => 'innodb',
        'initStatements' => 'SET NAMES utf8;',
      ),
    ),
  ),
  'resource' => 
  array (
    'default_setup' => 
    array (
      'connection' => 'default',
    ),
  ),
  'x-frame-options' => 'SAMEORIGIN',
  'MAGE_MODE' => 'production',
  'session' => 
  array (
    'save' => 'redis',
    'redis' => 
    array (
      'host' => '/var/run/redis-multi-a139e831.redis/redis.sock',
      'port' => '0',
      'password' => '',
      'timeout' => '2.5',
      'persistent_identifier' => '',
      'database' => '1',
      'compression_threshold' => '20480',
      'compression_library' => 'snappy',
      'log_level' => '1',
      'max_concurrency' => '20',
      'break_after_frontend' => '5',
      'break_after_adminhtml' => '30',
      'first_lifetime' => '600',
      'bot_first_lifetime' => '60',
      'bot_lifetime' => '7200',
      'disable_locking' => '0',
      'min_lifetime' => '60',
      'max_lifetime' => '2592000',
    ),
  ),
  'install' => 
  array (
    'date' => 'Mon, 07 May 2018 06:25:57 +0000',
  ),
  'system' => 
  array (
    'default' => 
    array (
      'dev' => 
      array (
        'debug' => 
        array (
          'debug_logging' => '0',
        ),
      ),
    ),
  ),
  'db_logger' => 
  array (
    'output' => 'disabled',
    'log_everything' => 1,
    'query_time_threshold' => '0.001',
    'include_stacktrace' => 1,
  ),
);
