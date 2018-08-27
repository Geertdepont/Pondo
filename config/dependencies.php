<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$cacheConfig = [
    'dependencies_cache_path' => __DIR__ . '/../data/cache/dependencies.cache.php',
    'dependencies_cache' => false
];

switch (getenv('APP_ENV')) {
    case 'production':
        $configPattern = __DIR__ . '/{global,local}/dependencies.php';
        break;
    case 'development':
        $configPattern = __DIR__ . '/{global,development,local}/dependencies.php';
        break;
    case 'testing':
        $configPattern = __DIR__ . '/{global,testing,local}/dependencies.php';
        break;
    default:
        $configPattern = __DIR__ . '/{global,local}/dependencies.php';
        break;
}

$configAggregate = new ConfigAggregator([
    new PhpFileProvider($configPattern),
], ($cacheConfig['dependencies_cache'] ? $cacheConfig['dependencies_cache_path'] : null));

return $configAggregate->getMergedConfig();
