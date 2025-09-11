<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\NotificationCtrl;
use App\Http\Controllers\GpxController;
use App\Http\Controllers\WPReactController;


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});


//Route::get('/ping', [App\Http\Controllers\ApiController::class, 'ping']);


// In routes/api.php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});

// routes/api.php
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


//waypoint controller api 

//Route::post('/upload-gpx', [WaypointController::class, 'upload']);
//Route::get('/waypoints', [WaypointController::class, 'index']);

// Route::get('/ping', fn() => 'pong');
Route::get('/ping', function () {
    return response()->json(['message' => 'Laravel OK']);
});


//GPXController 
//http://192.168.0.101:8000/api/GPX-UPLOADED 
Route::post('/GPX-UPLOADED', [GpxController::class, 'uploadGPX']);
Route::get('/GPX-GOT', [GpxController::class, 'extract']);

//Registration
Route::post('/register', [AuthController::class, 'register']);
Route::get('/registered_users', [AuthController::class, 'getUsers']);

//login handling 
Route::post('/login_react', [AuthController::class, 'login_react']);

//truncate method
Route::post('/delete_user', [AuthController::class, 'deleteUsers']);


// WP_react Controller POST
Route::post('/gpx-upload', [WPReactController::class, 'store']);
Route::get('/waypoints', [WPReactController::class, 'index']);
Route::post('/delete', [WPReactController::class, 'delete']);


Route::post('/notify', [NotificationCtrl::class, 'store']);
Route::get('/notifications', [NotificationCTRL::class, 'index']);  // For admin
   
