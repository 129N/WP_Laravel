<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/competition/cmp', function () {
        return Inertia::render('cmp');
    })->name('competition');
});
?>
