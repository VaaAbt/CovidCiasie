<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\Message;
use App\Utils\Auth;

class MessageController extends AbstractController
{
    public function getChat(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // $data['chats'] = Message::getUserChats(Auth::getUser());
        return $this->render($response, 'chat.html.twig');
    }

    public function createMessage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        Message::create($request->getParsedBody());
        header("Refresh:0");
    }
}