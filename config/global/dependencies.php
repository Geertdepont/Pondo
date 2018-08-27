<?php

use Pondo\Factory;

return [
    'services' => [
        'config' => include __DIR__ . '/../config.php'
    ],
    'aliases' => [
        \Doctrine\ORM\EntityManager::class => 'doctrine.entity_manager.orm_default',
        \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class => 'doctrine.driver.orm_default',
        'doctrine.cache.redis_instance' => \Redis::class,
    ],
    'factories' => [
        // error handling
        \Zend\Stratigility\Middleware\ErrorHandler::class => \Zend\Expressive\Container\ErrorHandlerFactory::class,
        \Zend\Expressive\Middleware\ErrorResponseGenerator::class => \Zend\Expressive\Container\ErrorResponseGeneratorFactory::class,

        // expressive factories
        \Zend\Stratigility\MiddlewarePipeInterface::class => \Zend\Expressive\Container\ApplicationPipelineFactory::class,
        \Zend\Expressive\MiddlewareContainer::class => \Zend\Expressive\Container\MiddlewareContainerFactory::class,
        \Zend\Expressive\MiddlewareFactory::class => \Zend\Expressive\Container\MiddlewareFactoryFactory::class,
        \Zend\Expressive\Router\Middleware\RouteMiddleware::class => \Zend\Expressive\Router\Middleware\RouteMiddlewareFactory::class,
        \Zend\Expressive\Router\Middleware\DispatchMiddleware::class => \Zend\Expressive\Router\Middleware\DispatchMiddlewareFactory::class,
        \Zend\HttpHandlerRunner\RequestHandlerRunner::class => Pondo\Factory\Expressive\RequestHandlerRunnerFactory::class,
        \Zend\HttpHandlerRunner\Emitter\EmitterInterface::class => \Zend\Expressive\Container\EmitterFactory::class,
        \Zend\Expressive\Response\ServerRequestErrorResponseGenerator::class => Pondo\Factory\Expressive\ServerRequestErrorResponseGeneratorFactory::class,
        \Psr\Http\Message\ServerRequestInterface::class => \Zend\Expressive\Container\ServerRequestFactoryFactory::class,
        \Psr\Http\Message\ResponseInterface::class => \Zend\Expressive\Container\ResponseFactoryFactory::class,

        // doctrine
        'doctrine.entity_manager.orm_default' => \ContainerInteropDoctrine\EntityManagerFactory::class,
        'doctrine.driver.orm_default' => \ContainerInteropDoctrine\DriverFactory::class,

//        // misc
//        \Pheanstalk\PheanstalkInterface::class => Factory\PheanstalkFactory::class,
//        \Redis::class => Factory\RedisFactory::class,
//        \BestelTaart\SupplierOrderSubmitter\OrderSubmitterFactory::class => Factory\OrderSubmitterFactoryFactory::class,
//        \Symfony\Component\Serializer\Serializer::class => Factory\SerializerFactory::class,
        \Pondo\UrlBuilder::class => Factory\UrlBuilderFactory::class,


        // router
        \Zend\Expressive\Router\RouterInterface::class => \Pondo\Factory\RouterFactory::class,
        \FastRoute\RouteCollector::class => \Pondo\Factory\FastRoute\RouteCollectorFactory::class,
        \FastRoute\Dispatcher::class => \Pondo\Factory\FastRoute\RouteDispatcherFactory::class,

        'logger.error' => Factory\Logger\MonologLogFactory::class,

        'logger.handler.error' => Factory\Logger\Handler\StreamHandlerFactory::class,
//        'logger.handler.system' => Factory\Logger\Handler\StreamHandlerFactory::class,
//        'logger.handler.jobs' => Factory\Logger\Handler\StreamHandlerFactory::class,

        'formatter.error.multi_line' => Factory\Logger\Formatter\MultiLineErrorFormatterFactory::class,


//
//        // routers
        'router.website' => \Pondo\Factory\Router\WebsiteRouterFactory::class,
//        'router.backoffice' => \BestelTaart\Factory\Router\BackOfficeRouterFactory::class,
//        'router.frontoffice' => \BestelTaart\Factory\Router\FrontOfficeRouterFactory::class,

        // middleware
        \Pondo\Middleware\PingPongMiddleware::class => Factory\Middleware\PingPongMiddlewareFactory::class,
        \Pondo\Middleware\ErrorHandler::class => Factory\Middleware\ErrorHandlerFactory::class,

    ]
];
