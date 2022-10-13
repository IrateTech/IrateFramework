<?php

namespace Application\Crons;

/**
 * Example of a cron for future development of crons:
 *
 * Ran from the root: php cron.php -c "test"
 */
return function ($system) {

    $system->crons->log('Starting test job...');
};