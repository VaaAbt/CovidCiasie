<?php

namespace App\Controller;

use App\Model\Announcement;
use App\Model\Group;
use App\Utils\Auth;
use App\Utils\FlashMessages;
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
            FlashMessages::set('group', 'The submitted data are invalid.');
            return $response->withHeader('Location', '/groups/new');
        }

        $group = new Group();
        $group->setAttribute('name', $payload['name']);
        $group->save();

        $group->users()->save(Auth::getUser());
        

        return $response->withHeader('Location', "/messages/group/{$group->getAttribute('id')}");
    }

    public function announcementView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'groups/announcement.html.twig');
    }

    public function announcement(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $group = Group::query()->where('id', '=', $args['id'])->first();

        $payload = $request->getParsedBody();

        $dataValidator = [
            'message' => Validator::isNotEmpty($payload['message'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            FlashMessages::set('group', 'The submitted data are invalid.');
            return $response->withHeader('Location', "/groups/{$group->getAttribute('id')}/announcement");
        }

        $announcement = [
            'group_id' => $group->getAttribute('id'),
            'message' => $payload['message']
        ];
        Announcement::create($announcement);

        return $response->withHeader('Location', "/messages/group/{$group->getAttribute('id')}");
    }
}