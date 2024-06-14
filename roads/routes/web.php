<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrechoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'message' => 'Hello, Inertia.js!',
    ]);
});

Route::get('/api/trechos', [TrechoController::class, 'index']);
Route::post('/api/trechos', [TrechoController::class, 'store']);

Route::get('/trechos/create', [TrechoController::class, 'create'])->name('trechos.create');