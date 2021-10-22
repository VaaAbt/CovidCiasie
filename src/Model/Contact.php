<?php

namespace App\Model;

use App\Utils\Auth;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    public static function create($data)
    {
        $contact = new Contact();

        $contact->setAttribute('user1_id', $data['user1']);
        $contact->setAttribute('user2_id', $data['user2']);
        $contact->save();

        return $contact;
    }

    public static function getContacts()
    {
        $userId = Auth::getUser()->getAttribute('id');

        return Contact::query()
        ->where('user1_id', '=', $userId)
        ->orWhere('user2_id', '=', $userId)
        ->get();
    }

    public static function remove($friend_id, $user_id)
    {
        return Contact::query()
        ->where([['user1_id', '=', $friend_id],['user2_id', '=', $user_id]])
        ->orWhere([['user1_id', '=', $user_id],['user2_id', '=', $friend_id]])
        ->delete();
    }

    public static function inContact($person_id, $user_id)
    {
        return Contact::query()
        ->where([['user1_id', '=', $person_id],['user2_id', '=', $user_id]])
        ->orWhere([['user1_id', '=', $user_id],['user2_id', '=', $person_id]])
        ->first();
    }
}