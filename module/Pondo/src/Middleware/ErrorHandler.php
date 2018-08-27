<?php

namespace Pondo\Middleware;

use Carbon\Carbon;
use ErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ErrorHandler
 */
class ErrorHandler implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $errorLog;

    /**
     * ErrorHandler constructor.
     * @param LoggerInterface $errorLog
     */
    public function __construct(LoggerInterface $errorLog)
    {
        $this->errorLog = $errorLog;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (! (error_reporting() & $errno)) {
                // Error is not in mask
                return;
            }
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            $response = $handler->handle($request);

            restore_error_handler();

            return $response;
        } catch (Throwable $error) {
            $carbon = Carbon::now();
            $traceId = dechex(time()) . '.' . $carbon->format('u');
            $level = LogLevel::ERROR;
            $message = sprintf(
                '[%s] Uncaught exception: %s: "%s" at %s line %s',
                $traceId,
                get_class($error),
                $error->getMessage(),
                $error->getFile(),
                $error->getLine()
            );
            $context = [
                'exception' => $error
            ];

            $this->errorLog->log($level, $message, $context);
        }

        restore_error_handler();

        return new JsonResponse(['errors' => ['Onbekende fout tijden het verwerken van uw verzoek.']], 500);
    }
}
