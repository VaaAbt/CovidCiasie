<?php

namespace App\Model;
use App\Utils\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'invitations';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    public static function create($data)
    {
        $invitation = new Invitation();

        $invitation->setAttribute('sender_id', $data['user1']);
        $invitation->setAttribute('receiver_id', $data['user2']);
        $invitation->save();

        return $invitation;
    }

    public static function getAllInvitations()
    {
        $userId = Auth::getUser()->getAttribute('id');

        return Invitation::query()
        ->where('receiver_id', '=', $userId)
        ->get();
    }

    public static function getAllInvitationsSent()
    {
        $userId = Auth::getUser()->getAttribute('id');

        return Invitation::query()
        ->where('sender_id', '=', $userId)
        ->get();
    }

    public static function deleteInvitation($data)
    {
        return Invitation::query()
        ->where([['sender_id', '=', $data['user1']],['receiver_id', '=', $data['user2']]])
        ->orWhere([['sender_id', '=', $data['user2']],['receiver_id', '=', $data['user1']]])
        ->delete();
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}