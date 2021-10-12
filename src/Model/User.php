<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Utils\Auth;

class User extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Create new user
     *
     * @param array $data
     * @return User
     */
    public static function create(array $data): User
    {
        $user = new User();

        $user->setAttribute('firstname', $data['firstname']);
        $user->setAttribute('lastname', $data['lastname']);
        $user->setAttribute('email', $data['email']);
        $user->setAttribute('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $user->save();

        return $user;
    }

    /**
     * Get the related groups of the user
     *
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'groups_users',
            'user_id',
            'group_id',
            'id',
            'id'
        );
    }

    public static function getAllLocations()
    {
        $locations = User::with('id', 'contamined', 'location')->get();

        return $locations;
    }

    public function talkedTo()
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    public function relatedTo()
    {
        return $this->hasMany(Message::class,'receiver_id');
    }

    public static function getUserFirstname($id){
        return User::where('id', '=', $id)->first()->firstname;
    }

    public static function getTalkedToUser()
    {
        return User::whereRelation('talkedTo', 'receiver_id', Auth::getUser()->getAttribute('id'))->orWhereRelation('relatedTo', 'sender_id', Auth::getUser()->getAttribute('id'))->groupBy('id')->get();
    }
}