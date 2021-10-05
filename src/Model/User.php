<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}