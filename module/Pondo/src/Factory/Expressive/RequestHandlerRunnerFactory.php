<?php

namespace Pondo\Factory\Expressive;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Response\ServerRequestErrorResponseGenerator;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\RequestHandlerRunner;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Stratigility\MiddlewarePipeInterface;

/**
 * Class RequestHandlerRunnerFactory
 */
class RequestHandlerRunnerFactory implements FactoryInterface
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
        return new RequestHandlerRunner(
            $container->get(MiddlewarePipeInterface::class),
            $container->get(EmitterInterface::class),
            $container->get(ServerRequestInterface::class),
            $container->get(ServerRequestErrorResponseGenerator::class)
        );
    }
    // phpcs:enable
}
