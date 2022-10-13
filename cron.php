<?php

defined('CLI_OPTIONS') || define('CLI_OPTIONS', getopt('c:', ['id::']));

// Validate c flag
if (!isset(CLI_OPTIONS['c'])) {
    die('No cron provided.' . PHP_EOL);
}

defined('ROOT_PATH') or define('ROOT_PATH', __DIR__);
require __DIR__ . '/vendor/autoload.php';

// Setup instance and run cron
(new \Irate\System())->crons->run(CLI_OPTIONS['c']);