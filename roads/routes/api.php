<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrechoController;

Route::get('/trechos', [TrechoController::class, 'index']);
Route::post('/trechos', [TrechoController::class, 'store']);