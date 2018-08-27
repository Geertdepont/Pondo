<?php

namespace Pondo\Factory\Middleware;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Pondo\Middleware\AddProductLinkMiddleware;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AddProductLinkMiddlewareFactory
 */
class AddProductLinkMiddlewareFactory implements FactoryInterface
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
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AddProductLinkMiddleware(
            $container->get(EntityManager::class)
        );
    }
    // phpcs:enable
}
