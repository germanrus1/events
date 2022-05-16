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

    public $users;

    protected $fillable = [
        'name',
        'description',
        'event_start',
        'event_end',
        'user_id',
        'users',
    ];

    /**
     * Checking intersects interval
     *
     * @param $request
     * @return bool
     */
    public static function checkIntersectsEvents($request) {
        // if current interval intersects in other interval
        $event = self::where('event_start', '<', $request->event_start)
            ->where(['user_id' => auth()->user()->id])
            ->where('event_end', '>', $request->event_start - self::THIRTY_MIN)
            ->orWhere(function ($query) use ($request) {
                $query->where('event_start', '<', $request->event_end)
                    ->where('event_end', '>', $request->event_end + self::THIRTY_MIN);
            })
            // if in current interval intersects other interval
            ->orWhere(function ($query) use ($request) {
                $query->where('event_start', '>', $request->event_start)
                    ->where('event_start', '<', $request->event_end);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('event_end', '>', $request->event_start)
                    ->where('event_end', '<', $request->event_end);
            })
            ->select('id')
            ->doesntExist();

        return $event;
    }

    /**
     * Gets the participants of the event
     */
    public static function users($event = '')
    {
        if ($event) {
            $members = Member::where(['event_id' => $event])->pluck('user_id')->all();
            $users = User::select(['id', 'name'])->whereIn('id', $members)->pluck('name', 'id')->all();
        } else {
            $users = User::select(['id', 'name'])->where('id', '<>', auth()->user()->id)->pluck('name', 'id')->all();
        }

        return $users;
    }
}
