<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/penduduk', [PendudukController::class, 'index']);
