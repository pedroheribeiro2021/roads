<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrechoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'message' => 'Hello, Inertia.js!',
    ]);
});

Route::post('/api/trechos', [TrechoController::class, 'store']);
