<?php

namespace Pondo\Factory\Logger\Formatter;

use Interop\Container\ContainerInterface;
use Monolog\Formatter\LineFormatter;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LineFormatterFactory
 */
class LineFormatterFactory implements FactoryInterface
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

        if (!isset($config['logs']['formatters'][$requestedName]) || !is_array($config['logs']['formatters'][$requestedName])) {
            throw new ServiceNotCreatedException(sprintf('Could not find configuration for log formatter %s', $requestedName));
        }

        $formatter = new LineFormatter(
            $config['logs']['formatters'][$requestedName]['format'] ?? null,
            $config['logs']['formatters'][$requestedName]['date_format'] ?? null,
            $config['logs']['formatters'][$requestedName]['allow_inline_line_breaks'] ?? false,
            $config['logs']['formatters'][$requestedName]['ignore_empty_context'] ?? false
        );

        return $formatter;
    }
    // phpcs:enable
}
