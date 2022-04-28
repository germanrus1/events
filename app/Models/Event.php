<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property integer $event_start
 * @property integer $event_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Event extends Model
{
    use HasFactory;

    const THIRTY_MIN = 1800; // 30 minutes in seconds
    const DAY = 86400; // 1 day in seconds
    const THREE_DAY = 259200; // 3 day in seconds
    const FOUR_DAY = 259200; // 3 day in seconds
    const WEEK = 604800; // 1 week in seconds
    const MONTH = 18144000; // 2 month in seconds

    protected $fillable = [
        'name',
        'description',
        'event_start',
        'event_end',
        'user_id',
    ];
}
