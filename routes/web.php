<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\WargaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== AUTH ==========

// Halaman Login
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Halaman Registrasi
Route::get('/signup', [AuthController::class, 'showRegistrationForm'])->name('signup');

// Proses Registrasi
Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');

// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========== PROTECTED (Hanya untuk yang sudah login) ==========
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Penduduk
    Route::resource('penduduk', PendudukController::class);

    // CRUD Data Keluarga KK
    Route::resource('keluargakk', KeluargaKKController::class);

    // CRUD Data Warga
    Route::resource('warga', WargaController::class);
});


// ========== DEFAULT REDIRECT ==========
Route::get('/', function () {
    return redirect()->route('login');
});
