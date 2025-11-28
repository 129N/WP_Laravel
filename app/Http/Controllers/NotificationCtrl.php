<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class NotificationCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($event_id)
    {
          $notifications = Notification::where('event_id', $event_id)->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Notification::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $event_id)
    {
        $request->validate([
            'participant_id' => 'required|integer',
            'type' => 'required|in:emergency,surrender,waypoint,offline',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'event_id' => $event_id,
        'participant_id' => $request->participant_id,
        'type' => $request->type,
        'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'data' => $notification], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete()
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
