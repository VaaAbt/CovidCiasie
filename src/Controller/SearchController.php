<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Contact;
use App\Model\Invitation;
use App\Model\GroupUser;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SearchController extends AbstractController
{
    public function search(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = Auth::getUser()->getAttribute('id');
        $data = $request->getParsedBody();
        $users = User::query()
        ->where('firstname', 'like', '%'. $data['name'].'%')
        ->orWhere('lastname', 'like', '%'. $data['name'].'%')
        ->get()->except($id);

        $data['results'] = $users;
        $data['contacts'] = Contact::getContacts();
        $data['invitations'] = Invitation::getAllInvitations();
        $data['invitations_sent'] = Invitation::getAllInvitationsSent();
        $data['groups'] = GroupUser::getGroupsOfUser($id);

        return $this->render($response, 'contacts/contacts.html.twig', $data);

    }

}