<?php

namespace App\Http\Controllers;

use App\Models\WP_react;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class WPReactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         set_time_limit(300);
         $waypoints = WP_react::where('type', 'wpt')->get();
         $trackpoints = WP_react::where ('type', 'trkpt')->get();
         return response()->json([
        'waypoints' => $waypoints,
        'trackpoints' => $trackpoints,
    ]);

    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        set_time_limit(300);

         if (!$request->hasFile('gpx_file')) {
            return response()->json(['error' => 'No GPX file uploaded.'], 400);
        }

        $file = $request->file('gpx_file');
        $gpxContent = file_get_contents($file->getRealPath());

        $gpxContent = str_replace('xmlns=', 'ns=', $gpxContent);
        $xml = simplexml_load_string($gpxContent);

         if (!$xml) return response()->json(['error' => 'Invalid XML'], 400);

 // Optional event_id: if present, link GPX to that event
    $eventId = $request->input('event_id'); // can be null
    if($eventId !== null){
         // optional validation
        $request->validate([ 'event_id' => 'exists:events,id'  ]);
    }
          // Parse Waypoints
        foreach ($xml->wpt as $wpt) {
            WP_react::create([
                'type' => 'wpt',
                'lat' => (float)$wpt['lat'],
                'lon' => (float)$wpt['lon'],
                'name' => (string)$wpt->name ?? null,
                'desc' => (string)$wpt->desc ?? null,
                'ele' => null,
                'event_id' => $eventId, // nullable
            ]);
        }

          // Parse Trackpoints
          foreach ($xml->trk->trkseg->trkpt as $trkpt) {
            WP_react::create([
                'type' => 'trkpt',
                'lat' => (float)$trkpt['lat'],
                'lon' => (float)$trkpt['lon'],
                'name' => null,
                'desc' => null,
                'ele' => (float)$trkpt->ele ?? null,
                'event_id' => $eventId, // nullable
            ]);
        }

        return response()->json(['message' => 'GPX file parsed and saved.']);
  

    }

    /**
     * Display the waypoints int the Admin MapView,
     */
    public function getEventWaypoints($eventId)
    {
        // WAYPOINT 
         set_time_limit(300);
         $waypoints = WP_react::where('event_id', $eventId)->where('type', 'wpt')->get();
        
         return response()->json(['waypoints' => $waypoints,]);
    }


    /**
     * Display the trackpoints int the Admin MapView,
     */
    public function getEventTrackpoints($eventId)
    {
        // TRACKPOINT
        set_time_limit(300);
        $trackpoints = WP_react::where('event_id', $eventId)->where ('type', 'trkpt')->orderBy('id')->get();

        return response()->json([ 'trackpoints' => $trackpoints ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete()
    {
        //
        WP_react::truncate();
        return response()->json(['message' => 'The gpx file delete OK']);
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WP_react $wP_react)
    {
        //
    }
}
