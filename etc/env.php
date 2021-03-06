<?php
return [
    'cache_types' => [
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
        'vertex' => 1
    ],
    'backend' => [
        'frontName' => 'superman'
    ],
    'crypt' => [
        'key' => '53d06f6fda785e88718fee0fd62d7efa'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'shop',
                'username' => 'root',
                'password' => 'Qwelkj@321',
                'active' => '1',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
            ]
        ]
    ],

    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'redis',
        'redis' => [
            'host' => '10.0.0.5',
            'port' => '6379',
            'password' => '',
            'timeout' => '20',
            'persistent_identifier' => '',
            'database' => '2',
            'compression_threshold' => '20480',
            'compression_library' => 'snappy',
            'log_level' => '1',
            'max_concurrency' => '2000',
            'break_after_frontend' => '15',
            'break_after_adminhtml' => '30',
            'first_lifetime' => '600',
            'bot_first_lifetime' => '60',
            'bot_lifetime' => '7200',
            'disable_locking' => '0',
            'min_lifetime' => '60',
            'max_lifetime' => '2592000'
        ]
    ],
    'install' => [
        'date' => 'Mon, 07 May 2018 06:25:57 +0000'
    ],
    'system' => [
        'default' => [
            'dev' => [
                'debug' => [
                    'debug_logging' => '0'
                ]
            ]
        ]
    ],
    'db_logger' => [
        'output' => 'disabled',
        'log_everything' => 1,
        'query_time_threshold' => '0.001',
        'include_stacktrace' => 1
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => '10.0.0.5',
                    'database' => '0',
                    'port' => '6379',
                    'auto_expire_lifetime' => '30000000',
                    'auto_expire_pattern' => '/LAYOUT_FRONTEND/'
                ],
                'id_prefix' => '9df_'
            ],
            'page_cache' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => '10.0.0.5',
                    'database' => '1',
                    'port' => '6379',
                    'compress_data' => '1'
                ],
                'id_prefix' => '9df_'
            ]
        ]
    ],
    'http_cache_hosts' => [
        [
            'host' => '10.0.0.3',
            'port' => '6081'
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => NULL
        ]
    ]
];
