<?php

namespace Pondo\Middleware;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class AddProductLinkMiddleware
 */
class AddProductLinkMiddleware implements MiddlewareInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * AddMiddleware constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param ServerRequestInterface  $request ServerRequestInterface.
     * @param RequestHandlerInterface $handler RequestHandlerInterface.
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        $errors = $this->validateInput($data);

        if (count($errors) > 0) {
            return new JsonResponse([
                'errors' => $errors
            ], 400);
        }

        return new JsonResponse([
            'link' => 'pong'
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function validateInput(array &$data): array
    {
        //TODO check all links
        $errors = [];
        if (!isset($data['productUrl'])) {
            $errors['productUrl'] = 'productUrl is not set';
        }

        return $errors;
    }
}
