<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Create new Announcement
     *
     * @param array $data
     * @return Announcement
     */
    public static function create(array $data): Announcement
    {
        $announcement = new Announcement();

        $announcement->setAttribute('group_id', $data['group_id']);
        $announcement->setAttribute('message', $data['message']);
        $announcement->save();

        return $announcement;
    }

    public static function getAnnoucementsFromGroup(int $group_id): Collection
    {
        return Announcement::query()
            ->where([['group_id', '=', $group_id]])
            ->get();
    }

}