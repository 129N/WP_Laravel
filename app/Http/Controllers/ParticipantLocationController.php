<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ParticipantLocation;
use Illuminate\Http\Request;

class ParticipantLocationController extends Controller
{
    //participant Location necessarry things

    public function store(Request $request, $event_id){
        $request->validate([
            'user_id' => 'required|exists:user_reacts,id',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'speed'=> 'nullable|numeric',
            'heading'=> 'nullable|numeric',
        ]);

        ParticipantLocation::created([
            'event_id' => $event_id,
            'user_id' => $request->user_id,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'speed' => $request->speed,
            'heading' => $request->heading,
        ]);

        return response() ->json(['message' => 'GPS update stored']);
    }


    public function getUserLocation($event_id){ //why event id?
         $latest = ParticipantLocation::select('participant_locations.*')
            ->where('event_id', $event_id)
            ->latest('created_at')
            ->get()
            ->groupBy('user_id')
            ->map(fn($rows) => $rows->first())
            ->values();

        return response()->json($latest);
    }   
}
