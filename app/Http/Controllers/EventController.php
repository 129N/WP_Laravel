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

        $events = Event::with(['creator:id,name,email'])
        ->withCount('registrations')->get();

        //for clean json structure 
        $events = $events->map(function ($event){
            return [
                'id' => $event->id,
                'event_code' => $event->event_code,
                'event_title' => $event->event_title,
                'description' => $event->description,
                'event_date' => $event->event_date,
                'creator_name' => $event->creator->name ?? 'Unknown',
                'creator_email' => $event->creator->email ?? null,
                'registration_count' => $event->registrations_count,
            ];
        });

        return response()->json($events, 200);
    }

    public function showEvent($event_code)
{
    $event = Event::where('event_code', $event_code)
        ->with(['creator:id,name,email'])
        ->firstOrFail();

    return response()->json([
        'id' => $event->id,
        'event_code' => $event->event_code,
        'event_title' => $event->event_title,
        'description' => $event->description,
        'event_date' => $event->event_date,
        'creator_name' => $event->creator->name ?? 'Unknown',
        'creator_email' => $event->creator->email ?? null,
    ], 200);
}

    // Creates a new event
        public function store(Request $request)
    {
        $lastEvent = Event::latest()->first();
        $nextNumber = $lastEvent ? intval(substr($lastEvent->event_code, 2)) + 1 : 1;
        $eventCode = 'EV' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);


        $user = $request->user();
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
            'created_by'   =>  $user->id, // ✅ from token
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event'   => $event,
        ], 201);
        
    }

// POST: register a single participant to an event
        public function registerParticipant(Request $request, $event_code)
    {
         // Validate input
        $validated = $request->validate([
            'user_id'    => 'required|integer', // participant user_id
            'group_name' => 'nullable|string|max:255', //solo is OK
        ]);

        // Make sure event exists
        // $event = Event::findOrFail($id);
        $event = Event::where('event_code', $event_code)->firstOrFail();


        //Get user ID 
        $user = $request->user();
        $userId = $validated['user_id'] ?? optional($request->user())->id;

        if(!$userId){
            return response()->json(['error' => 'User not authenticated or user_id missing'], 401);
        }
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }


        //Check for duplicate registration 
        $regsiteredCheck = EventRegistration::where('event_id', $event->id)
        ->where('user_id', $userId)->exists();

        if ($regsiteredCheck) {
        return response()->json(['error' => 'User already registered for this event'], 409);
        }

        //create registration 
        $registration = EventRegistration::create([
            'event_id'   => $event->id,
            'user_id'    => $userId,
            'group_name' => $validated['group_name'] ?? null,
            'status'     => 'registered',
            'participant_name'  => $user->name, 
            'email'             => $user->email,
        ]);
        
        return response()->json([
            'message' => 'Participant registered successfully',
            'registration' => $registration,
        ], 201);
    }
// GET the registerParticipant
        public function getParticipant( $event_code)
    {
        $event = Event::where('event_code', $event_code) -> firstOrFail();
        $participants = EventRegistration::where('event_id', $event ->id)
        ->with('user') -> get()->map(function ($reg) {
            return [
                'id' => $reg->id,
                'user_id' => $reg->user_id,
                'name' => $reg->user->name ?? null, // NEW ADD
                'email' => $reg->user->email ?? null,// NEW ADD
                'team' => $reg->group_name,
                'status' => $reg->status,
            ];
        });

        return response()->json($participants);
    }

    public function checkIn(Request $request, $event_code){
        $user = $request->user(); // auth:sanctum ensures this exists

        // find registration:
        $registration = EventRegistration::where('event_id', $event_code)
            ->where('user_id', $user->id)
            ->first();

        if (!$registration) {
            return response()->json(['error' => 'User not registered for this event'], 404);
        }

        // update status
        $registration->update([
            'status' => 'active',
            'check_in_time' => now(),
        ]);

        return response()->json([
            'message' => 'Check-in successful',
            'registration' => $registration
        ]);
    }


    //single user delete of registration
    public function deleteParticipants($id){

        $registration = EventRegistration::find($id);

        if(!$registration){
            return response()->json(['error' => 'Participant not found'], 404);
        }
        $registration -> delete();
        return response()-> json(['message' => 'Participant deleted successfully'], 200);
    }



    //Only deleting its event, not the registred user.
    public function destroy($id, Request $request){
        $event = Event::find($id);

        if(!$event){
            return response()-> json(['error' => 'Event not found'], 404);
        }

        if ($event->created_by !== $request->user()->id) {
        return response()->json(['error' => 'Unauthorized'], 403);
        }


        $event->delete();

        return response()-> json(['message' => 'Event deleted successfully'], 200);
    }
}
