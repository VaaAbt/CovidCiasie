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

}