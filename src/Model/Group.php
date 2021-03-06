<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get messages related to the group
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'group_id', 'id');
    }

    /**
     * Get the related users of the groups
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'groups_users',
            'group_id',
            'user_id',
            'id',
            'id'
        );
    }

    /**
     * Get the related announcements to the group
     *
     * @return HasMany
     */
    public function annoucements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'group_id');
    }

    /**
     * Get the related files to the group
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'group_id');
    }

    /**
     * Check if the user is a member of the group
     *
     * @param User $user
     * @return bool
     */
    public function hasMember(User $user): bool
    {
        return GroupUser::query()
            ->where('group_id', '=', $this->getAttribute('id'))
            ->where('user_id', '=', $user->getAttribute('id'))
            ->exists();
    }

    public static function getGroupName($id)
    {
        return Group::query()
            ->where('id', '=', $id)
            ->first()
            ->getAttribute('name');
    }
}