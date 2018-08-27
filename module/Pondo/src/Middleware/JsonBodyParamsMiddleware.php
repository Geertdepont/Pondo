<?php

namespace Pondo\Middleware;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zend\Expressive\Helper\BodyParams\JsonStrategy;

/**
 * Class JsonBodyParamsMiddleware
 */
class JsonBodyParamsMiddleware extends BodyParamsMiddleware
{
    /** @noinspection PhpMissingParentConstructorInspection
     * JsonBodyParamsMiddleware constructor.
     */
    public function __construct()
    {
        $this->addStrategy(new JsonStrategy());
    }
}
