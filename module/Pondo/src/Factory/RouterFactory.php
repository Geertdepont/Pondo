<?php

namespace Pondo\Factory;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RouterFactory
 */
class RouterFactory implements FactoryInterface
{
    // phpcs:disable Squiz.Commenting.FunctionComment
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $router = new FastRouteRouter(
            $container->get(RouteCollector::class),
            $container->get(Dispatcher::class)
        );

        $config = $container->has('config') ? $container->get('config') : [];

        if (isset($config['routes'])) {
            foreach ($config['routes'] as $routeInfo) {
                $router->addRoute($this->createRoute($routeInfo));
            }
        }

        return $router;
    }
    // phpcs:enable

    /**
     * @param array $params
     * @return Route
     */
    protected function createRoute(array $params)
    {
        $path = $params['path'];
        $middleware = $params['middleware'];
        $methods = isset($params['methods']) ? (array) $params['methods'] : Route::HTTP_METHOD_ANY;
        $name = $params['name'] ?? null;
        $options = $params['options'] ?? [];

        $route = new Route($path, $middleware, $methods, $name);
        $route->setOptions($options);

        return $route;
    }
}
