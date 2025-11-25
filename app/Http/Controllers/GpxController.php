<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waypoint;
use App\Models\TrackPoint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\WP_react;
//       Log::info('Gpx Processor hit');
class GpxController extends Controller
{
    // it may not need.
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
     

    }

    public function download()
    {
            set_time_limit(300);
            $waypoints = WP_react::where('type', 'wpt')->get();
            $trackpoints = WP_react::where ('type', 'trkpt')->get();
            return response()->json([
            'waypoints' => $waypoints,
            'trackpoints' => $trackpoints,
        ]);

    }

    public function delete()
    {
        //
        WP_react::truncate();
        return response()->json(['message' => 'The gpx file delete OK']);
    }

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