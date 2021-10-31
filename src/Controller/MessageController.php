<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\Group;
use App\Model\GroupUser;
use App\Model\Message;
use App\Model\User;
use App\Model\File;
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
        $data['user_id'] = $args['id']; // for active status
        $data['contact'] = Contact::inContact($id, $args['id']);

        return $this->render($response, 'messages/direct.html.twig', $data);
    }

    public function createMessage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        if (!Contact::inContact($args['id'], $id)) {
            FlashMessages::set('messages', 'Connot send the message. This user is not in your contacts.');
            return $response->withHeader('Location', '/messages')->withStatus(403);
        }

        $msg = $request->getParsedBody();

        if($_POST['action'] == 'upload'){

            $file = [
                'file_name' => $_FILES['file']['name'],
                'file_type' => $_FILES['file']['type'],
                'file_size' => $_FILES['file']['size'],
                'file_content' => file_get_contents($_FILES['file']['tmp_name'])
            ];

            $newFile = File::create($file);
            $message = [
                'receiver_id' => $args['id'],
                'message' => $msg['message'],
                'file_id' => $newFile->id
            ];
        }else{
            $message = [
                'receiver_id' => $args['id'],
                'message' => $msg['message']
            ];
        }

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

        $user = Auth::getUser();
        $id = $user->getAttribute('id');
        $data['users'] = User::getTalkedToUser();
        $data['groups'] = GroupUser::getGroupsOfUser($id);
        $data['group'] = $group;
        $data['group_id'] = $args['id']; // for active status
        $data['messages'] = $group->messages()->get();
        $data['members'] = $group->users()->get();
        $data['announcements'] = $group->annoucements()->get();
        $data['files'] = $group->files()->get();
        $data['contactsNotInGroup'] = $user->getUsersContactsNotInGroup($group);

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