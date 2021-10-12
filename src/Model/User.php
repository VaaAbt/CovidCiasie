<?php

namespace App\Model;

use App\Utils\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return User::with('id', 'contamined', 'location')->get();
    }

    public function talkedTo(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function relatedTo(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public static function getUserFirstname($id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->first()
            ->getAttribute('firstname');
    }

    /**
     * Get all users who the user has talked to
     *
     * @return Collection
     */
    public static function getTalkedToUser(): Collection
    {
        $userId = Auth::getUser()->getAttribute('id');

        return User::query()
            ->whereRelation('talkedTo', 'receiver_id', $userId)
            ->orWhereRelation('relatedTo', 'sender_id', $userId)
            ->groupBy('id')
            ->get();
    }
}