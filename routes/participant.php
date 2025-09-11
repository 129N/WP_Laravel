<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/participant', function () {
        return Inertia::render('participant');
    })->name('dashboard.participant');
});
?>

