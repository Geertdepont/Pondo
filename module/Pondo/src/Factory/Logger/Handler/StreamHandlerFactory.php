<?php

namespace Pondo\Factory\Logger\Handler;

use Interop\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class StreamHandlerFactory
 */
class StreamHandlerFactory implements FactoryInterface
{

    // phpcs:disable Squiz.Commenting
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        if (!isset($config['logs']['handlers'][$requestedName]) || !is_array($config['logs']['handlers'][$requestedName])) {
            throw new ServiceNotCreatedException(sprintf('Could not find configuration for log handler %s', $requestedName));
        }

        if (!isset($config['logs']['handlers'][$requestedName]['file'])) {
            throw new ServiceNotCreatedException(sprintf('Could not find the "file" settting for log handler %s', $requestedName));
        }

        $stream = new StreamHandler($config['logs']['handlers'][$requestedName]['file']);

        if (isset($config['logs']['handlers'][$requestedName]['formatter'])) {
            $stream->setFormatter($container->get($config['logs']['handlers'][$requestedName]['formatter']));
        }

        return $stream;
    }
    // phpcs:enable
}
