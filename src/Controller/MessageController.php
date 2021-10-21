<?php

namespace App\Controller;

use App\Model\Group;
use App\Model\GroupUser;
use App\Model\Message;
use App\Model\User;
use App\Utils\Auth;
use App\Utils\FlashMessages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessageController extends AbstractController
{
    public function messagesView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);

        return $this->render($response, 'messages/index.html.twig', $data);
    }

    public function getUserMessagesView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);

        $data['messages'] = Message::getDiscussionMessages($args['id']);

        return $this->render($response, 'messages/direct.html.twig', $data);
    }

    public function createMessage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $msg = $request->getParsedBody();
        $message = [
            'receiver_id' => $args['id'],
            'message' => $msg['message']
        ];
        Message::create($message);
        return $response->withHeader('Location', '/messages/user/' . $args['id'])->withStatus(302);
    }

    public function getGroupMessagesView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        /** @var Group|null $group */
        $group = Group::query()->where('id', '=', $args['id'])->first();
        if (!$group) {
            FlashMessages::set('messages', 'Group not found.');
            return $response->withHeader('Location', '/messages')->withStatus(404);
        }

        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);

        $data['group'] = $group;
        $data['messages'] = $group->messages()->get();
        $data['members'] = $group->users()->get();

        return $this->render($response, 'messages/group.html.twig', $data);
    }

    public function createGroupMessage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();
        
        $message = [
            'group_id' => $args['id'],
            'message' => $payload['message']
        ];
        Message::create($message);

        return $response->withHeader('Location', '/messages/group/' . $args['id'])->withStatus(302);
    }
}