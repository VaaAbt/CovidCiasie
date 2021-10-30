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

    public static function getAllLocations(): array
    {
        $users = User::where('contamined', 1)->get();

        $data = array();
        foreach ($users as $user) {
            $location = Location::getLocationId($user->id);
            $data[] = ['longitude' => $location->longitude, 'latitude' => $location->latitude];
        }

        return $data;
    }

    public function talkedTo(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function relatedTo(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all the contacts of the user
     *
     * @return Collection
     */
    public function getUsersInContacts(): Collection
    {
        $id = $this->getAttribute('id');

        $contacts1 = Contact::query()
            ->where('user1_id', '=', $id)
            ->get();

        $contacts1 = $contacts1->map(function (Contact $contact) {
            return $contact->user2()->first();
        });

        $contacts2 = Contact::query()
            ->where('user2_id', '=', $id)
            ->get();

        $contacts2 = $contacts2->map(function (Contact $contact) {
            return $contact->user1()->first();
        });

        return $contacts1->concat($contacts2);
    }

    /**
     * Get the users contacts which are not members of the group
     *
     * @param Group $group
     * @return Collection
     */
    public function getUsersContactsNotInGroup(Group $group): Collection
    {
        $contacts = $this->getUsersInContacts();

        return $contacts->filter(function (User $user) use ($group) {
            return !$group->hasMember($user);
        });
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

    /**
     * Get all users that matches given string
     *
     * @return Collection
     */
    public static function getUsersWith($search): Collection
    {
        return User::query()->where('firstname', 'LIKE', '%' . $search . '%')->get();
    }
}