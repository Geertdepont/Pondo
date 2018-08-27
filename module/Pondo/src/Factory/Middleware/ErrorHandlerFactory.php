<?php

namespace Pondo\Factory\Middleware;

use Pondo\Middleware\ErrorHandler;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ErrorHandlerFactory
 */
class ErrorHandlerFactory implements FactoryInterface
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
        return new ErrorHandler(
            $container->get('logger.error')
        );
    }
    // phpcs:enable
}
