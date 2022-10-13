<?php

/**
 * IrateFramework Configuration File.
 *
 * The best way to handle multiple environments with this
 * configuration, is to have a .env file that variables within here
 * check against.
 */

$config = [

    'PROD_VERSION' => $_ENV['env'] === 'production' ? 'v1.00001' : false,

    /**
     * Base URL of Application
     */
    'BASE_URL' => isset($_ENV['baseUrl']) ? $_ENV['baseUrl'] : '',

    /**
     * Database Information
     */
    'DB_HOST' => isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : '',
    'DB_NAME' => isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : '',
    'DB_USER' => isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : '',
    'DB_PASSWORD' => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '',
    'DB_CHARSET' => isset($_ENV['DB_CHARSET']) ? $_ENV['DB_CHARSET'] : 'utf8mb4',
    'DB_SSL' => isset($_ENV['DB_SSL']) ? $_ENV['DB_SSL'] : null,

    /**
     * Show dev errors
     */
    'SHOW_ERRORS' => $_ENV['env'] === 'dev' ? true : false,

    /**
     * Router Defaults
     */
    'ROUTE_DEFAULT_CONTROLLER' => 'Site',
    'ROUTE_DEFAULT_ACTION' => 'index',

    /**
     * Defined Routes
     */
    'ROUTES' => [],

    'PRELOADED_LIBRARIES' => [],

    /**
     * Encoding key for things like sessions
     */
    'ENCODING_KEY' => 'test123',

    /**
     * SMTP Configuration
     */
    'SMTP_HOST' => '',
    'SMTP_USERNAME' => '',
    'SMTP_PASSWORD' => '',
    'SMTP_PORT' => 587,

    /**
     * Application parameters
     */
    'PARAMS' => [
        'siteTitle' => 'Irate Framework',
    ],
];

return (object) $config;