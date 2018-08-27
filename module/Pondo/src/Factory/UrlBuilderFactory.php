<?php

namespace Pondo\Factory;

use Pondo\UrlBuilder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UrlBuilderFactory
 */
class UrlBuilderFactory implements FactoryInterface
{

    // phpcs:disable Squiz.Commenting.FunctionComment
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotCreatedException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        if (!isset($config['url']) || !is_array($config['url'])) {
            throw new ServiceNotCreatedException('Cannot create service, \'url\' key is missing in the configuration or is not an array');
        }

        return new UrlBuilder($config['url']);
    }
    // phpcs:enable
}
