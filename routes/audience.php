<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/audience', function () {
        return Inertia::render('audience');
    })->name('dashboard.audience');
});
?>

