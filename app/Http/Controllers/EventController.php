<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //  
    public function index()
    {
        // list events

        $events = Event::withCount('registrations')->get();

        return response()->json($events, 200);
    }


    // Creates a new event
        public function store(Request $request)
    {
        $lastEvent = Event::latest()->first();
        $nextNumber = $lastEvent ? intval(substr($lastEvent->event_code, 2)) + 1 : 1;
        $eventCode = 'EV' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        // stores each property

        // validate input
    $validated = $request->validate([
        'event_title'      => 'required|string|max:255',
        'description'      => 'required|string',
        'event_date'       => 'required|date',
        // 'event_creatorName'=> 'required|string|max:255', //admin's name
    ]);

    // inject our generated code
    // $validated['created_by'] = $request->user()->id;// auto generated
    // $validated['event_code'] = $eventCode;

    // Create event 
    $event = Event::create([
        'event_code'   => $eventCode,
        'event_title'  => $validated['event_title'],
        'description'  => $validated['description'],
        'event_date'   => $validated['event_date'],
        'created_by'   => $request->user()->id, // ✅ from token
    ]);

    return response()->json([
        'message' => 'Event created successfully',
        'event'   => $event,
    ], 201);
        
    }

    // register a participant to an event
        public function registerParticipant(Request $request, $id)
    {
         // Validate input
        $validated = $request->validate([
            'user_id'    => 'required|integer', // participant user_id
            'group_name' => 'nullable|string|max:255',
        ]);

        // Make sure event exists
        $event = Event::findOrFail($id);

        $registration = EventRegistration::create([
            'event_id'   => $event->id,
            'user_id'    => $validated['user_id'],
            'group_name' => $validated['group_name'] ?? null,
            'status'     => 'registered',

        ]);
        
        return response()->json([
            'message' => 'Participant registered successfully',
            'registration' => $registration,
        ], 201);
    }
}
