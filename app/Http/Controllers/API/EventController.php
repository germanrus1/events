<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $dateWeek = $request->get('dateWeek');

        if ($dateWeek) {
            $dateWeek = Carbon::createFromFormat('Y-m-d', $dateWeek)->getTimestamp();
        } else {
            $dateWeek = Carbon::now()->getTimestamp();
        }
        $events = Event::where('event_start', '>', $dateWeek - Event::THREE_DAY)
            ->where('event_start', '<', $dateWeek + Event::FOUR_DAY)
            ->orderBy('event_start')
            ->get();

        $results = [];

        foreach ($events as $key => $event) {
            $results['w_' . date('w', $event->start_event)][] = $event;
        }

        return EventResource::collection($results);
    }

    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['event_start'] = $request->event_start;
        $validated['event_end'] = $request->event_end;

        if (Event::checkIntersectsEvents($request)) {
            $event = Event::create($validated);
            if ($event->id) {
                foreach ($validated['users'] as $user_id) {
                    Member::create(['user_id' => $user_id, 'event_id' => $event->id]);
                }
            }
        } else {
            return response()->json([
                'errors' => [
                    'datetime_interval' => ['This slot is booked.']
                ],
                'message' => 'The given data was invalid.'
            ], 422);

        }

        return new EventResource($event);
    }

    /** Get all users or users from events
     *
     *
     */
    public function getUsers(Request $request)
    {
        $users = Event::users($request->input('event_id'));

        return response()->json(['users' => $users]);
    }

    public function show(Event $event)
    {
        $event->event_start = Carbon::parse($event->event_start)->setTimezone('UTC')->format('Y-m-d H:i');
        $event->event_end = Carbon::parse($event->event_end)->setTimezone('UTC')->format('Y-m-d H:i');
        $event->users = array_keys(Event::users($event->id));

        return new EventResource($event);
    }

    public function update(EventRequest $request, Event $event)
    {
        $validated = $request->validated();
        // format date to timestamp
        $validated['event_start'] = Carbon::createFromFormat('Y-m-d H:i:s', $validated['event_start'])->getTimestamp();
        $validated['event_end'] = Carbon::createFromFormat('Y-m-d H:i:s', $validated['event_end'])->getTimestamp();
        $event->update($validated);

        return new EventResource($event);
    }

    /**
     * Delete event element
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        $events = Event::all();
//
//        return view('index', [
//            'events' => $events,
//        ]);
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|max:255',
//            'description' => 'nullable|string',
//            'event_start' => 'required|date:Y-m-d H:i:s',
//            'event_end' => 'required|date:Y-m-d H:i:s',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect('/')
//                ->withErrors($validator, 'event')
//                ->withInput();
//        }
//
//        $validated = $validator->validated();
//        $event = new Event();
//        $event->name = $validated['name'];
//        $event->description = $validated['description'];
//        $event->event_start =  Carbon::createFromFormat('Y-m-d H:i:s', $validated['event_start'])->timestamp;
//        $event->event_end =  Carbon::createFromFormat('Y-m-d H:i:s', $validated['event_end'])->timestamp;
//
//        var_dump($event);die;
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Models\Event  $event
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Event $event)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Models\Event  $event
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Event $event)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Models\Event  $event
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Event $event)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\Event  $event
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Event $event)
//    {
//        //
//    }
}
