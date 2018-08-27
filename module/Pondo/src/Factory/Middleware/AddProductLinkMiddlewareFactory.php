<?php

declare(strict_types=1);

namespace Pondo\Factory\Middleware;

use Pondo\Middleware\AddProductLinkMiddleware;
use Pondo\Middleware\HomePageHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AddProductLinkMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new AddProductLinkMiddleware($router, $template, get_class($container));
    }
}