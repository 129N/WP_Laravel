<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\NotificationCtrl;
use App\Http\Controllers\GpxController;
use App\Http\Controllers\WPReactController;


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

// routes/api.php
Route::post('/login', [AuthController::class, 'login']);
//Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

  Route::get('/registered_users', [AuthController::class, 'getUsers']);

    // Dangerous endpoint: keep admin-only or remove.
Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);

// Everything else requires Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//http://192.168.0.101:8000/api/GPX-UPLOADED 
// Everything else requires Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Current user
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // Waypoints / GPX
    Route::get('/waypoints', [WPReactController::class, 'index']);            // read
    Route::post('/gpx-upload', [WPReactController::class, 'store']);          // RN upload (if used)
    Route::post('/delete', [WPReactController::class, 'delete']);             // consider making this DELETE + admin

    // Legacy GPX endpoints (keep if used by RN)
    Route::post('/GPX-UPLOADED', [GpxController::class, 'uploadGPX']);
    Route::get('/GPX-GOT', [GpxController::class, 'extract']);

    // Notifications
    Route::post('/notify', [NotificationCtrl::class, 'store']);
    Route::get('/notifications', [NotificationCtrl::class, 'index']);         // fix class name case

    // Admin-only or now is ok 
    Route::middleware('role:admin')->group(function () {
        // Route::get('/registered_users', [AuthController::class, 'getUsers']);
       // Route::delete('/registered_users', [AuthController::class, 'deleteUsers']);
        // Alternatively keep your original path but change it to DELETE:
        // Route::delete('/delete_user', [AuthController::class, 'deleteUsers']);
    });
});

//Delete zone

// In routes/api.php
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Route::get('/registered_users', [AuthController::class, 'getUsers']);

// Route::post('/GPX-UPLOADED', [GpxController::class, 'uploadGPX']);
// Route::get('/GPX-GOT', [GpxController::class, 'extract']);


// //truncate method
// Route::post('/delete_user', [AuthController::class, 'deleteUsers']);


// // WP_react Controller POST
// Route::post('/gpx-upload', [WPReactController::class, 'store']);
// Route::get('/waypoints', [WPReactController::class, 'index']);
// Route::post('/delete', [WPReactController::class, 'delete']);


// Route::post('/notify', [NotificationCtrl::class, 'store']);
// Route::get('/notifications', [NotificationCTRL::class, 'index']);  // For admin
   

//waypoint controller api 
//Route::post('/upload-gpx', [WaypointController::class, 'upload']);
//Route::get('/waypoints', [WaypointController::class, 'index']);

