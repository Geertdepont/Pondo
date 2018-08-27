<?php

declare(strict_types=1);

namespace Pondo;

use App\Handler\HomePageHandler;
use App\Handler\HomePageHandlerFactory;
use Pondo\Middleware\AddProductLinkMiddleware;
use Pondo\Middleware\PingPongMiddleware;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                PingPongMiddleware::class => PingPongMiddleware::class,
                AddProductLinkMiddleware::class => AddProductLinkMiddleware::class,
            ],
            'factories'  => [
                \Pondo\Middleware\HomePageHandler::class => \Pondo\Factory\Middleware\HomePageHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
