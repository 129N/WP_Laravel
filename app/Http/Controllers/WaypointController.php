<?php

namespace App\Http\Controllers;

use App\Models\Waypoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaypointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Log::info('WAYPOINT STORE REQUEST', ['data' => $request->all()]);  // 👈 Log the incoming data

    return response()->json(['status' => 'received']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Waypoint $waypoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waypoint $waypoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Waypoint $waypoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waypoint $waypoint)
    {
        //
    }

    public function upload(Request $request)
    {

        
        Log::info('Upload endpoint hit');
        
        $request-> validate([
           'gpx_file' => 'required|file|mimes:xml,gpx',
            // 'gpx_file' => 'required|file',
            // 'gpx_file' => 'required|file|mimetypes:application/gpx+xml,text/xml,application/xml',
        ]);

      // Get the uploaded file
        $file = $request->file('gpx_file');

        if(!$file) {
            return response() ->json(['Error' => 'No file uploaded'], 400);
        }

        // Load the GPX file
        $gpx = simplexml_load_file($file->getRealPath());

          // Check for any error in loading the GPX file
        if (!$gpx) {
            return response()->json(['error' => 'Invalid GPX file'], 400);
        }

        // Loop through the waypoints and save them to the database
    

        foreach($gpx->wpt as $wpt) {
            Waypoint::create([
                'name' => (string) $wpt->name,
                'latitude' => (float) $wpt['lat'],
                'longitude' => (float) $wpt['lon'],
                'elevation' => isset($wpt->ele) ? (float) $wpt->ele : null,
                'time' => isset($wpt->time) ? date('Y-m-d H:i:s', strtotime((string)$wpt->time)) : null,
            ]);
        }

        return response()->json(
            ['message' => 'Waypoints uploaded successfully']);
    }

    public function index()
    {
        return Waypoint::all();
    }

}
