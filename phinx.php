<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return
    [
    'paths' => [
        'migrations' => __DIR__ . '/Application/Database/migrations',
        'seeds' => __DIR__ . '/Application/Database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'env',
        'env' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'] === 'host.docker.internal' ? '127.0.0.1' : $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => '3306',
            'charset' => isset($_ENV['DB_CHARSET']) ? $_ENV['DB_CHARSET'] : 'utf8',
        ],
    ],
    'version_order' => 'creation',
];