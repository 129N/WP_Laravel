<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GpxFile;
use App\Models\GpxPoint;
use Illuminate\Http\Request;
use App\Models\Waypoint;
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

    public function download($fileId)
    {
        $gpxFile = GpxFile::findOrFail($fileId);

        $fullPath = storage_path("app/private/{$gpxFile->file_path}");

            if (!file_exists($fullPath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            return response()->download(
                $fullPath,
                ($gpxFile->route_name ?? 'route') . '.gpx',
                ['Content-Type' => 'application/gpx+xml']
            );

    }

    private function buildGpxFromPoints($gpxFile, $points)
{
    $wpts = "";
    $trkpts = "";

    foreach ($points as $p) {
        if ($p->type === 'wpt') {
            $wpts .= "<wpt lat=\"{$p->lat}\" lon=\"{$p->lon}\">\n";
            if ($p->name) $wpts .= "<name>{$p->name}</name>\n";
            $wpts .= "</wpt>\n";
        } else {
            $trkpts .= "<trkpt lat=\"{$p->lat}\" lon=\"{$p->lon}\">\n";
            $trkpts .= "<time>" . now()->toIso8601String() . "</time>\n";
            $trkpts .= "</trkpt>\n";
        }
    }

    return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <gpx version=\"1.1\" creator=\"WaypointTracker\" xmlns=\"http://www.topografix.com/GPX/1/1\">
        {$wpts}
        <trk>
            <name>{$gpxFile->route_name}</name>
            <trkseg>
                {$trkpts}
            </trkseg>
        </trk>
    </gpx>";
}


    public function list()
    {
        //return response()->json(GpxFile::orderBy('id', 'desc')->get());
        try{

            $files = GpxFile::orderBy('id', 'desc')
            ->get()->map(function ($file){
                return[
                    'id' => $file->id, 
                    'route_name' => $file->route_name,
                    'uploaded_by' => $file->uploaded_by, 
                    'event_id' => $file->event_id, 
                    'file_path' => $file->file_path, 
                    'created_at' => $file->created_at ? $file->created_at->toDateTimeString() : null,
                ];
            });
            return response() -> json($files, 200);
        }
        catch(\Exception $e){
            return response()->json([ 'error' => 'Failed to load GPX files', 'details' => $e->getMessage(), ], 500);
        }
    }

    public function delete($fileId)
    {
       $gpxFile = GpxFile::find($fileId);

        if (!$gpxFile) {
            return response()->json(['error' => 'file_id not found'], 404);
        }

// Delete all points associated with this GPX file
        GpxPoint::where('gpx_file_id', $fileId)->delete();

// Delete the GPX file metadata
        $gpxFile->delete();

        return response()->json(['message' => 'GPX file deleted', 'file_id' => $fileId]);

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

        $fileId = $request->input('file_id');       // null for new
        $routeName = $request->input('route_name') ?? ('Recorded Route ' . time());
 /* =============================
       UPDATE EXISTING GPX FILE
    ============================== */
    if ($fileId) {
        $gpxFile = GpxFile::find($fileId);

        if (!$gpxFile) {
            return response()->json(['error' => 'Invalid file_id'], 400);
        }

        // Remove old points
        GpxPoint::where('gpx_file_id', $fileId)->delete();

        // Update name
        $gpxFile->route_name = $routeName;
        $gpxFile->save();

    } else {

        /* =============================
           CREATE NEW GPX FILE
        ============================== */
        $gpxFile = GpxFile::create([
            'route_name'  => $routeName,
            'uploaded_by' => $request->user()->id ?? null,
        ]);
    }


// Parse Waypoints
        foreach ($xml->wpt as $wpt) {
            GpxPoint::create([
                'gpx_file_id' => $gpxFile->id, // NEW ID for uploading
                'type' => 'wpt',
                'lat' => (float)$wpt['lat'],
                'lon' => (float)$wpt['lon'],
                'name' => (string)$wpt->name ?? null,
                'desc' => (string)$wpt->desc ?? null,
                'ele' => null,

                'event_id' => null,               // ✅ IMPORTANT
            ]);
        }

// Parse Trackpoints
          foreach ($xml->trk->trkseg->trkpt as $trkpt) {
            GpxPoint::create([
                'gpx_file_id' => $gpxFile->id, // NEW ID for uploading
                'type' => 'trkpt',
                'lat' => (float)$trkpt['lat'],
                'lon' => (float)$trkpt['lon'],
                'name' => null,
                'desc' => null,
                'ele' => (float)$trkpt->ele ?? null,

                'event_id' => null,               // ✅ IMPORTANT
            ]);
        }
    return response()->json([
        'message' => 'GPX saved',
        'file_id' => $gpxFile->id,
        'route_name' => $gpxFile->route_name
    ]);
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