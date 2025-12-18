<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ParticipantLocation;
use Illuminate\Http\Request;

class ParticipantLocationController extends Controller
{
    //participant Location necessarry things

    public function store(Request $request, $event_code){
        $request->validate([
            'user_id' => 'required|exists:user_reacts,id',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'speed'=> 'nullable|numeric',
            'heading'=> 'nullable|numeric',
        ]);

        $event = Event::where('event_code', $event_code) -> firstOrFail();

        ParticipantLocation::create([
            'event_id' => $event->id,
            'user_id' => $request->user_id,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'speed' => $request->speed,
            'heading' => $request->heading,
            'created_at' => now(),
        ]);

        return response() ->json(['message' => 'GPS update stored']);
    }


public function getUserLocation($event_code)
{
    $event = Event::where('event_code', $event_code)->firstOrFail();

    // Get latest location per user for this event
    $latest = ParticipantLocation::where('event_id', $event->id)
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('user_id')
        ->map(fn ($rows) => $rows->first())
        ->values();

    return response()->json($latest);
}

// public function getUserLocation($event_code)
// {
//     $event = Event::where('event_code', $event_code)->firstOrFail();

//     $latest = ParticipantLocation::whereIn('id', function ($query) use ($event) {
//         $query->selectRaw('MAX(id)')
//               ->from('participant_locations')
//               ->where('event_id', $event->id)
//               ->groupBy('user_id');
//     })
//     ->get(['user_id', 'lat', 'lon', 'speed', 'heading', 'created_at']);

//     return response()->json($latest);
// }


  
}
