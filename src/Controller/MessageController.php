<?php

namespace App\Controller;

use App\Model\Group;
use App\Model\GroupUser;
use App\Model\Message;
use App\Model\User;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessageController extends AbstractController
{
    public function messagesView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);
        return $this->render($response, 'messages.html.twig', $data);
    }

    public function getUserMessageView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);
        $data['messages'] = Message::getDiscussionMessages($args['id']);
        $data['chatName'] = User::getUserFirstname($args['id']);
        return $this->render($response, 'messages.html.twig', $data);
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

    public function getGroupMessageView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);
        $data['messages'] = Message::getGroupDiscussionMessages($args['id']);
        $data['chatName'] = Group::getGroupName($args['id']);
        return $this->render($response, 'messages.html.twig', $data);
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

    public function searchUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $search = $request->getParsedBody();
        $id = Auth::getUser()->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);
        $data['usersSearch'] = User::getUsersWith($search['username']);

        return $this->render($response, 'messages.html.twig', $data);
    }
}