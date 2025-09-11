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
    public function index()
    {
          $notifications = Notification::latest()->get();
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
    public function store(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|integer',
            'type' => 'required|in:help,surrender',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
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
