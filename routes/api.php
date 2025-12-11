<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\NotificationCtrl;
use App\Http\Controllers\GpxController;
use App\Http\Controllers\WPReactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Models\EventRegistration;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParticipantLocationController;

//http://192.168.0.101:8000/ is used for Waypoint tracker 

// export const BASE_URL = 'https://49e00eec2c67.ngrok-free.app/api'; stable connection 

// Health checks (public)
Route::get('/ping', fn () => response()->json(['message' => 'Laravel OK Itsuku Nakano'])); // single ping
Route::get('/status', fn () => response()->json(['status' => 'ok']));


/**
 * Authentication
 * 
 */
//Auth (public)
//Registration & login handling
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login_react', [AuthController::class, 'login_react']);


Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


    // Dangerous endpoint: keep admin-only or remove.
Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);



/**
 * GPX tracking system
 * 
 */
// Legacy GPX endpoints (keep if used by RN)

//Used for recording the route page
    Route::post('/ADM_GPX_UPLOAD', [GpxController::class, 'store']); // reuse the store
    Route::get('/ADM_GPX_DOWNLOAD/{file_id}', [GpxController::class, 'download']);
    Route::delete('/ADM_GPX_DELETE/{file_id}', [GpxController::class, 'delete']);

Route::get('/ADM_GPX_LIST', [GpxController::class, 'list']);

    
// Used for uploading the file to the event page.
// Waypoints / GPX
    Route::get('/filefetch', [WPReactController::class, 'index']);            // read by ALL USERS
        Route::get('/events/{event_code}/waypoints', [WPReactController::class, 'getEventWaypoints']); //Waypoints only
        Route::get('/events/{event_code}/trackpoints', [WPReactController::class, 'getEventTrackpoints']); //Trackpoints only
    Route::post('/gpx-upload', [WPReactController::class, 'store']);          // React Web and RN upload (if used)
        Route::post('/events/{event_code}/gpx-upload', [WPReactController::class, 'storeForEvent']); //For admin, type the Event code 

    Route::post('/delete', [WPReactController::class, 'delete']);             // consider making this DELETE + admin
    //safety delete    
    Route::delete('/events/{event_code}/gpx', [WPReactController::class, 'deleteEventGpx']);

/**
 * Event Register Controller
 * 
 */
    //public routes
    Route::get('/events', [EventController::class, 'index']); // list events


    Route::get('/events/{event_code}', [EventController::class, 'showEvent']);

   
        Route::get('/events/{event_code}/participants', [EventController::class, 'getParticipant']);
    

     //Single registration 
Route::middleware('auth:sanctum')->group(function (){
    // Route::get('/events', [EventController::class, 'index']); // list events
    Route::post('/events', [EventController::class, 'store']); // create event (admin)

    Route::post('/events/{event_code}/check-in', [EventController::class, 'checkIn']);

    Route::delete('/registrations/{event_code}', [EventController::class, 'destroy']);

    
     Route::post('/events/{event_code}/register', [EventController::class, 'registerParticipant']); // register participant
});



/**
 * Multiple registration  
 * 
 */
Route::middleware('auth:sanctum')->group(function() {
    //Participant creates a team 
    Route::post('/teams', [TeamController::class, 'createTeam']);

    // Get all teams for a given event (for admin)
    Route::get('/teams/event/{id}/register', [TeamController::class, 'getTeamsByEvent']);
    
    // Delete team (admin only)
    Route::delete('/teams/{id}/delete', [TeamController::class, 'deleteTeam']);
});


/**
 * Event Register Controller
 * 
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/overview', [AdminController::class, 'getFullOverview']);
});

/**
 * User location in an event
 * 
 */
Route::middleware('auth:sanctum') ->group(function() {
    //live gps
    Route::post('/events/{event_code}/location', [ParticipantLocationController::class, 'store']);
// Notifications in event
    Route::post('/events/{event_code}/notifications', [NotificationCtrl::class, 'store']); 
});

 //fetch latest GPS for event
    Route::get('/events/{event_code}/locations', [ParticipantLocationController::class, 'getUserLocation']);
    Route::get('/events/{event_code}/notifications', [NotificationCtrl::class, 'index']); 



// Everything else requires Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Current user
    Route::get('/user', fn (Request $request) => $request->user());


    // Admin-only or now is ok 
    Route::middleware(['auth:sanctum','role:admin'])->group(function () {
         Route::get('/registered_users', [AuthController::class, 'getUsers']);
       // Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);
        // Alternatively keep your original path but change it to DELETE:
         Route::delete('/delete_user', [AuthController::class, 'deleteUsers']);
    });

     // Participant or admin can see their own profile, etc. 
     // DO IT LATER 
    // Route::get('/participants', [ParticipantController::class, 'index']);
});




// Everything else requires Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

