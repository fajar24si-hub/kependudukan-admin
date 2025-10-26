<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KeluargaKKController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'index'])->name('login'); // Ubah dari 'keluargakk,login' ke 'index'
Route::post('/login', [AuthController::class, 'login']);

// Registration Routes
Route::get('/signup', [AuthController::class, 'showRegistrationForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

// Protected Routes - Add middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::get('/penduduk', [PendudukController::class, 'index']);

    Route::resource('keluargakk', KeluargaKKController::class);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
