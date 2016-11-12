<?php

require_once 'src/bootstrap.php';

/** @var $app \Ex\Core\ExApplication */
return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'db',
        'db' => [
            'adapter' => 'mysql',
            'host' => $app['config']['database']['db.options']['host'],
            'name' => $app['config']['database']['db.options']['dbname'],
            'user' => $app['config']['database']['db.options']['user'],
            'pass' => $app['config']['database']['db.options']['password'],
            'port' => $app['config']['database']['db.options']['port'],
            'charset' => $app['config']['database']['db.options']['charset'],
        ]
    ]
];
