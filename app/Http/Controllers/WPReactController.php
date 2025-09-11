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
         return response()->json([
        'waypoints' => $waypoints
    ]);

    }

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
        set_time_limit(300);

         if (!$request->hasFile('gpx_file')) {
            return response()->json(['error' => 'No GPX file uploaded.'], 400);
        }

          $file = $request->file('gpx_file');
        $gpxContent = file_get_contents($file->getRealPath());

        $gpxContent = str_replace('xmlns=', 'ns=', $gpxContent);
        $xml = simplexml_load_string($gpxContent);

         if (!$xml) return response()->json(['error' => 'Invalid XML'], 400);

          // Parse Waypoints
        foreach ($xml->wpt as $wpt) {
            WP_react::create([
                'type' => 'wpt',
                'lat' => (float)$wpt['lat'],
                'lon' => (float)$wpt['lon'],
                'name' => (string)$wpt->name ?? null,
                'desc' => (string)$wpt->desc ?? null,
                'ele' => null,
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
            ]);
        }

        return response()->json(['message' => 'GPX file parsed and saved.']);
  

    }

    /**
     * Display the specified resource.
     */
    public function show(WP_react $wP_react)
    {
        //
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, WP_react $wP_react)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WP_react $wP_react)
    {
        //
    }
}
