<?php


return [
    'factories' => [
        \Zend\Expressive\Middleware\ErrorResponseGenerator::class   => \Zend\Expressive\Container\WhoopsErrorResponseGeneratorFactory::class,
        'Zend\Expressive\Whoops'                                    => \Zend\Expressive\Container\WhoopsFactory::class,
        'Zend\Expressive\WhoopsPageHandler'                         => \Zend\Expressive\Container\WhoopsPageHandlerFactory::class,

    ]
];
