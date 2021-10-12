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
    public static function getUserChats(){

        $id =  Auth::getUser()->getAttribute('id');
        $messages = Message::where('sender_id', '=', $id)->orWhere('receiver_id', '=', $id)->get();

        $messages = $messages->toArray();

        $newMessages = [];
        foreach ($messages as $msg) {
            foreach ($newMessages as $newMsg) {
                $found = false;
                if($newMsg['sender_id'] == $id || $newMsg['receiver_id'] == $id){
                    $found = true;
                    break;
                }
            }
            if(!$found){
                array_push($newMessages, $msg);
            }
        }

        dump($newMessages);
        return $messages;
    }

    /**
     * Get all message from a discussion between 2 person
     *
     * @return Messages
     */
    public static function getDiscussionMessages($person_id){

        $messages = Message::where('sender_id', '=', Auth::getUser())->orWhere('reveiver_id', '=', $person_id)->get();
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

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }
    
}   