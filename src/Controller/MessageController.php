<?php

namespace App\Controller;

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
        return $this->render($response, 'messages.html.twig', $data);
    }
}