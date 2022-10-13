<?php

$config = require __DIR__ . '/../Config.php';
$config->CRON_CONFIG = true;
return (object) $config;