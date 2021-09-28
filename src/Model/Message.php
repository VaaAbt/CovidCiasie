<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Auth;

class Message extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $message;

    /**
     * Create new message
     *
     * @return Message
     */
    public static function create($data){

        $message = new Message();

        $message->setAttribute('sender_id', Auth::getUser());
        $message->setAttribute('receiver_id', $data['receiver_id']);
        $message->setAttribute('group_id', $data['group_id']);
        $message->setAttribute('message', $data['message']);
        $message->save();

        return $message;
    }

    /**
     * Get all chats that a user have
     *
     * @return Messages
     */
    public static function getUserChats($user_id){

        $messages = Message::where('sender_id', $user_id)->get();

        return $messages;
    }

    /**
     * Get all message from a discussion between 2 person
     *
     * @return Messages
     */
    public static function getDiscussionMessages($person_id){

        $messages = Message::where([['sender_id', Auth::getUser()],['reveiver_id', $person_id]])->get();

        return $messages;
    }

    /**
     * Get all message from a group discussion
     *
     * @return Messages
     */
    public static function getGroupDiscussionMessages($group_id){

        $messages = Message::where('group_id', $group_id)->get();
        
        return $messages;
    }
}   