<?php

namespace App\Controller;

use App\Model\Group;
use App\Utils\Auth;
use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GroupController extends AbstractController
{
    public function newView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'groups/new.html.twig');
    }

    public function new(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();

        $dataValidator = [
            'name' => Validator::isNotEmpty($payload['name'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            return $response->withHeader('Location', '/groups/new');
        }

        $group = new Group();
        $group->setAttribute('name', $payload['name']);
        $group->save();

        $group->users()->save(Auth::getUser());

        return $response->withHeader('Location', '/messages');
    }
}