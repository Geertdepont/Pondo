<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

/**
 * File required to run the doctrine CLI tool.
 */

include __DIR__ . '/../vendor/autoload.php';

$dotEnv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotEnv->load();
$dotEnv->required('APP_ENV')->allowedValues(['production', 'development', 'testing']);

$container = require __DIR__ . '/../config/services.php';
$em        = $container->get(\Doctrine\ORM\EntityManager::class);
$cli       = ConsoleRunner::createHelperSet($em);

return $cli;
