<?php

namespace App\Controller;

use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Render a view
     *
     * @param ResponseInterface $response - The response used for the render
     * @param string $view - Name of the file of the view
     * @param array $data - Parameters used for the view
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, string $view, array $data = []): ResponseInterface
    {
        try {
            /** @var Twig $twig */
            $twig = $this->container->get('twig');

            return $twig->render($response, $view, $data);
        } catch (Exception $e) {
            $response->getBody()->write('Cannot render the view');
            return $response->withStatus(500);
        }
    }
}