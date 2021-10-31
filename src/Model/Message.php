<?php

namespace App\Model;

use App\Utils\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public $timestamps = false;

    /**
     * Create new message
     *
     * @param array $data
     * @return Message
     */
    public static function create(array $data): Message
    {
        $message = new Message();

        $message->setAttribute('sender_id', Auth::getUser()->getAttribute('id'));
        $message->setAttribute('receiver_id', $data['receiver_id']);
        $message->setAttribute('group_id', $data['group_id']);
        $message->setAttribute('message', $data['message']);
        $message->save();

        return $message;
    }

    /**
     * Get all message from a discussion between 2 person
     *
     * @param int $person_id
     * @return Collection
     */
    public static function getDiscussionMessages(int $person_id): Collection
    {
        $userId = Auth::getUser()->getAttribute('id');

        return Message::query()
            ->where([['sender_id', '=', $userId], ['receiver_id', '=', $person_id], ['group_id', '=', NULL]])
            ->orWhere([['sender_id', '=', $person_id], ['receiver_id', '=', $userId], ['group_id', '=', NULL]])
            ->get();
    }

    /**
     * Get all message from a group discussion
     *
     * @param int $group_id
     * @return Collection
     */
    public static function getGroupDiscussionMessages(int $group_id): Collection
    {
        return Message::query()->where('group_id', '=', $group_id)->get();
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}