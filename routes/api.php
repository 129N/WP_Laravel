<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\NotificationCtrl;
use App\Http\Controllers\GpxController;
use App\Http\Controllers\WPReactController;
use App\Http\Controllers\EventController;

//http://192.168.0.101:8000/ is used for Waypoint tracker 

// export const BASE_URL = 'https://49e00eec2c67.ngrok-free.app/api'; stable connection 

// Health checks (public)
Route::get('/ping', fn () => response()->json(['message' => 'Laravel OK Itsuku Nakano'])); // single ping
Route::get('/status', fn () => response()->json(['status' => 'ok']));


//Route::get('/ping', [App\Http\Controllers\ApiController::class, 'ping']);

//Auth (public)
//Registration & login handling
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login_react', [AuthController::class, 'login_react']);


Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// routes/api.php
//Route::post('/login', [AuthController::class, 'login']);

  //Route::get('/registered_users', [AuthController::class, 'getUsers']);

    // Dangerous endpoint: keep admin-only or remove.
Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);


// Legacy GPX endpoints (keep if used by RN)
    Route::post('/GPX-UPLOADED', [GpxController::class, 'uploadGPX']);
    Route::get('/GPX-GOT', [GpxController::class, 'extract']);
    
    // Waypoints / GPX
    Route::get('/waypoints', [WPReactController::class, 'index']);            // read
    Route::post('/gpx-upload', [WPReactController::class, 'store']);          // RN upload (if used)
    Route::post('/delete', [WPReactController::class, 'delete']);             // consider making this DELETE + admin

/**
 * Event Creation Controller
 * 
 */


Route::middleware('auth:sanctum')->group(function (){
    Route::get('/events', [EventController::class, 'index']); // list events
    Route::post('/events', [EventController::class, 'store']); // create event (admin)
    Route::post('/events/{id}/register', [EventController::class, 'registerParticipant']); // register participant
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
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

