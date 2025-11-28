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


//Route::post('/login', [AuthController::class, 'login']);

  //Route::get('/registered_users', [AuthController::class, 'getUsers']);

    // Dangerous endpoint: keep admin-only or remove.
Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);



/**
 * GPX tracking system
 * 
 */
// Legacy GPX endpoints (keep if used by RN)

//Used for recording the route page
    Route::post('/ADM_GPX_UPLOAD', [GpxController::class, 'store']); // reuse the store
    Route::get('/ADM_GPX-DOWNLOAD', [GpxController::class, 'download']);
    Route::delete('/ADM_GPX_DELETE', [GpxController::class, 'delete']);

// Used for uploading the file to the event page.
// Waypoints / GPX
    Route::get('/filefetch', [WPReactController::class, 'index']);            // read
    Route::post('/gpx-upload', [WPReactController::class, 'store']);          // RN upload (if used)
    Route::post('/delete', [WPReactController::class, 'delete']);             // consider making this DELETE + admin

/**
 * Event Register Controller
 * 
 */
    //public routes
    Route::get('/events', [EventController::class, 'index']); // list events

     //Single registration 
Route::middleware('auth:sanctum')->group(function (){
    // Route::get('/events', [EventController::class, 'index']); // list events
    Route::post('/events', [EventController::class, 'store']); // create event (admin)
    Route::post('/events/{id}/register', [EventController::class, 'registerParticipant']); // register participant
    Route::delete('/registrations/{id}', [EventController::class, 'destroy']);
});



/**
 * Multiple registration  
 * 
 */

// Route::post('/event_registrations', [EventController::class, 'event']);
// Route::get('/event_registrations', [EventController::class, 'index']);

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
    Route::post('/events/{event_id}/location', [ParticipantLocationController::class, 'store']);

    //fetch latest GPS for event
    Route::get('/events/{event_id}/locations', [ParticipantLocationController::class, 'getUserLocation']);
});




// Everything else requires Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Current user
    Route::get('/user', fn (Request $request) => $request->user());

    // Notifications
    Route::post('/notify', [NotificationCtrl::class, 'store']);
    Route::get('/notifications', [NotificationCtrl::class, 'index']);         // fix class name case

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

