<?php

namespace Pondo\Factory\FastRoute;

use FastRoute\DataGenerator\GroupCountBased as RouteGenerator;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std as RouteParser;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RouteCollector
 */
class RouteCollectorFactory implements FactoryInterface
{

    // phpcs:disable Squiz.Commenting.FunctionComment
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $routeCollector = new RouteCollector(
            new RouteParser(),
            new RouteGenerator()
        );

        return $routeCollector;
    }
    // phpcs:enable
}
