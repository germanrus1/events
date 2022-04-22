<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use EventRequest;
use EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        return EventResource::collection(Event::all());
    }

    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());

        return new EventResource($event);
    }

    public function show(Event $event)
    {
        return new EventResource($event);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return new EventResource($event);
    }

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
