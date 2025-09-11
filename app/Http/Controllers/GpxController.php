<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waypoint;
use App\Models\TrackPoint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
//       Log::info('Gpx Processor hit');
class GpxController extends Controller
{
    
    public function uploadGPX(Request $request){

      Log::info('Gpx Processor hit');

      $request->validate([
               'file' => 'required|file|mimes:xml,gpx', // Ensures file is present and is either .xml or .gpx
        ]);

        // Decode waypoints and trackPoints from JSON

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = $file->storeAs('gpx_uploads', $file->getClientOriginalName());

            Log::info('Uploaded file name: ' . $request->file('file')->getClientOriginalName());
            Log::info('Stored file path: ' . Storage::path($path));
      
            $xmlContent = Storage::get($path);
            $xml = simplexml_load_string($xmlContent);

            $namespace = 'http://www.topografix.com/GPX/1/1';
            $xml->registerXPathNamespace('gpx', $namespace);

             if ($xml === false) {
                Log::error('Failed to parse GPX XML.');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid GPX file.',
                ], 400);
        }
            // Handle XML parsing and store waypoints
            // $waypoints = json_decode($request->input('waypoints'), true) ?? [];
            foreach ($xml->wpt as $wpt) {
                $waypoint = new Waypoint();
                $waypoint->latitude  = (string) $wpt['lat'];
                $waypoint->longitude   = (string) $wpt['lon'];
                $waypoint->name = isset($wpt->name) ? (string) $wpt->name : 'Unnamed';
                $waypoint->save();
            } 
            // Retrieve all waypoints from the database
            $waypoints = Waypoint::all();

            return response()->json([
                'success' => true,
                'message' => 'waypoint:GPX file uploaded and processed successfully!',
                'waypoints' => $waypoints, // Return waypoints instead of the raw XML data
            ]);
        }
        else{
                return response()->json([
                'success' => false,
                'message' => 'waypoint:GPX file uploadedfailed!',
      
            ], 400);
        }


     
    //     $trackPoints =  $xml->trk->trkseg->trkpt ?? [];
    //     // Save track points
    //    if (is_array($trackPoints) && count($trackPoints) > 0) {
    //     foreach ($trackPoints as $pt) {
    //         TrackPoint::create([
    //             'latitude' => (float) $pt['lat'],
    //             'longitude' => (float) $pt['lon'],
    //         ]);
    //     }
    // } else {
    //     Log::warning('No track points found in the GPX file');
    // }
    //     return response()->json([
    //          'success' => false,
    //         'message' => 'trackPoints: Invalid file or no file uploaded.'
    //     ], 400);
    }

    public function extract()
    {
        $waypoints = Waypoint::all();
        //$trackPoints = TrackPoint::all();
        return response()->json([
            'waypoints' => $waypoints,
            //'trackPoints' => $trackPoints,
        ]);

    }


}
