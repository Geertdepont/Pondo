<?php

namespace Pondo\Factory\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Interop\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class BackOfficeRouterFactory
 */
class WebsiteRouterFactory implements FactoryInterface
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
        $middlewareFactory = $container->get(MiddlewareFactory::class);
        $router = new FastRouteRouter(
            $container->get(RouteCollector::class),
            $container->get(Dispatcher::class)
        );

        $config = $container->has('config') ? $container->get('config') : [];

        if (isset($config['routes']['website'])) {
            foreach ($config['routes']['website'] as $routeInfo) {
                $router->addRoute($this->createRoute($routeInfo, $middlewareFactory));
            }
        }

        return $router;
    }
    // phpcs:enable

    /**
     * @param array             $params
     * @param MiddlewareFactory $middlewareFactory
     * @return Route
     */
    protected function createRoute(array $params, MiddlewareFactory $middlewareFactory)
    {
        $path = $params['path'];
        $middleware = $params['middleware'] instanceof MiddlewareInterface ? $params['middleware'] : $middlewareFactory->prepare($params['middleware']);
        $methods = isset($params['methods']) ? (array) $params['methods'] : Route::HTTP_METHOD_ANY;
        $name = $params['name'] ?? null;
        $options = $params['options'] ?? [];

        $route = new Route($path, $middleware, $methods, $name);
        $route->setOptions($options);

        return $route;
    }
}
