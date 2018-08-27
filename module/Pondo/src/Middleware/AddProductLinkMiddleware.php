<?php

declare(strict_types=1);

namespace Pondo\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

/**
 * Class AddProductLinkMiddleware
 * @package Pondo\Middleware
 */
class AddProductLinkMiddleware implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    /**
     * AddProductLinkMiddleware constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface|null $template
     * @param string $containerName
     */
    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName
    )
    {
        $this->router = $router;
        $this->template = $template;
        $this->containerName = $containerName;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
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
