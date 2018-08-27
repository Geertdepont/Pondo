<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

//// Composer autoload
include __DIR__ . '/../vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require __DIR__ . '/../config/container.php';

    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    $factory = $container->get(\Zend\Expressive\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require __DIR__ . '/../config/pipeline.php')($app, $factory, $container);
    (require __DIR__ . '/../config/routes.php')($app, $factory, $container);

    $app->run();
})();



//ini_set('html_errors', 0);
//
//// Composer autoload
//include __DIR__ . '/../vendor/autoload.php';
//
//$dotEnv = new \Dotenv\Dotenv(__DIR__ . '/..');
//$dotEnv->load();
//$dotEnv->required('APP_ENV')->allowedValues(['production', 'development', 'testing']);
//
//$container = require __DIR__ . '/../config/services.php';
//
//$router = $container->get('router.website');
//
//$app = new \Zend\Expressive\Application(
//    $container->get(\Zend\Expressive\MiddlewareFactory::class),
//    $container->get(\Zend\Stratigility\MiddlewarePipeInterface::class),
//    new \Zend\Expressive\Router\RouteCollector($router),
//    $container->get(\Zend\HttpHandlerRunner\RequestHandlerRunner::class)
//);
//
//// the Content-Length header is automatically inserted, so the frontend is able to determine the download progress
//$app->pipe(\Pondo\Middleware\ErrorHandler::class);
//$app->pipe(\Zend\Expressive\Helper\ContentLengthMiddleware::class);
//$app->pipe(new \Tuupola\Middleware\CorsMiddleware([
//    'origin' => ['*'],
//    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
//    'headers.allow' => ['Content-Type', 'Accept-Language', 'Content-Language', 'Accept', 'X-CID', 'User-Agent', 'Origin'],
//    'headers.expose' => ['Set-Cookie', 'Content-Length'],
//    'credentials' => true,
//    'cache' => 0
//]));
//
//$app->pipe(new \Zend\Expressive\Router\Middleware\RouteMiddleware($router));
////$app->pipe(\Pondo\Middleware\SessionMiddleware::class);
////$app->pipe(\Pondo\Middleware\Website\GoogleAnalyticsClientMiddleware::class);
//$app->pipe(\Zend\Expressive\Router\Middleware\DispatchMiddleware::class);
//$app->pipe(\Pondo\Middleware\NotFoundHandler::class);
//
//$app->run();
