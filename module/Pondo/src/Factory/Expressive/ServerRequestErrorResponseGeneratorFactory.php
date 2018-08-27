<?php

namespace Pondo\Factory\Expressive;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Response\ServerRequestErrorResponseGenerator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ServerRequestErrorResponseGeneratorFactory
 */
class ServerRequestErrorResponseGeneratorFactory implements FactoryInterface
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
        $config = $container->has('config') ? $container->get('config') : [];
        $debug  = $config['debug'] ?? false;

        return new ServerRequestErrorResponseGenerator(
            $container->get(ResponseInterface::class),
            $debug
        );
    }
    // phpcs:enable
}
