<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GPXController;


Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/participant', function () {
        return Inertia::render('participant');
    })->name('participant');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('admin');
    })->name('admin');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/audience', function () {
        return Inertia::render('audience');
    })->name('audience');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/competition/cmp', function () {
        return Inertia::render('cmp');
    })->name('competition');
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/participant.php';
require __DIR__.'/audience.php';
require __DIR__.'/cmp.php';