<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\UserController; // ✅ Tambahkan ini

// Halaman Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Halaman Registrasi
Route::get('/signup', [AuthController::class, 'showRegistrationForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');

// Halaman user
Route::resource('user', UserController::class);

// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUD Data Penduduk
Route::resource('penduduk', PendudukController::class);

// CRUD Data Keluarga KK
Route::resource('keluargakk', KeluargaKKController::class);

// CRUD Data Warga
Route::resource('warga', WargaController::class);

// ✅ CRUD Data User (tanpa middleware)
//Route::resource('user', UserController::class);

// Redirect default
Route::get('/', function () {
    return redirect()->route('login');
});
