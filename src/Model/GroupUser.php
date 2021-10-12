<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class GroupUser extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'groups_users';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get related group
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    /**
     * Get related user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all the groups of the user
     *
     * @param int $id
     * @return Collection
     */
    public static function getGroupsOfUser(int $id): Collection
    {
        return GroupUser::query()->where('user_id', '=', $id)->get();
    }
}