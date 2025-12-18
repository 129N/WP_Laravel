<?php

namespace App\Http\Controllers;

use App\Events\EmergencyMessageSent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyChatController extends Controller
{
    //

    public function send (Request $request, $event_code, $participant_id){
        $request-> validate([
            'message' => 'required|string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        broadcast(new EmergencyMessageSent(
            $event_code,
            $participant_id,
            [
                'from' => $user->id,
                'message' => $request->message,
                'lat' => $request->lat,
                'lon' => $request->lon,
                'time' => now()->toISOString(),
            ]
        ));

        return response()->json(['sent' => true]);
    }


    public function openRoom($event_code, $participant_id)
    {
        // You may store room metadata in DB if needed.

        return response()->json([
            'room' => "emergency.event.$event_code.participant.$participant_id",
            'opened' => true
        ]);
    }


}
