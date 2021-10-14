<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MapController extends AbstractController
{

    public function mapView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'map.html.twig');
    }

    public function getOtherLocations(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $locations = User::getAllLocations();
        return $this->render($response, 'map.html.twig', [
            'locations' => $locations
        ]);
    }

}