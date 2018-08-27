<?php

namespace Pondo\Factory\Logger;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ErrorLoggerFactory
 */
class MonologLogFactory implements FactoryInterface
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

        if (!isset($config['logs']['instances'][$requestedName]) || !is_array($config['logs']['instances'][$requestedName])) {
            throw new ServiceNotCreatedException(sprintf('Could not find configuration for log instance %s', $requestedName));
        }

        $name = $config['logs']['instances'][$requestedName]['name'] ?? $requestedName;
        $handlers = (array) $config['logs']['instances'][$requestedName]['handlers'] ?? [];

        $log = new Logger($name);

        foreach ($handlers as $handler) {
            $log->pushHandler($container->get($handler));
        }

        return $log;
    }
    // phpcs:enable
}
