<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\MultipleuploadsController;
use App\Http\Controllers\PeristiwaKematianController;
use App\Http\Controllers\PeristiwaKelahiranController;

// ========== PUBLIC ROUTES (TANPA AUTH) ==========
Route::middleware('guest')->group(function () {
    // Redirect default
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Halaman Login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Halaman Signup (Registrasi) - TAMBAHKAN
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

    // Halaman Forgot Password - TAMBAHKAN
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
        ->name('password.request');
});

// ========== PROTECTED ROUTES (DENGAN AUTH) ==========
Route::middleware(['checkislogin'])->group(function () {
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/quick-stats', [DashboardController::class, 'quickStats'])->name('dashboard.quick-stats');

    // ========== ROUTE DENGAN CHECKISLOGIN + CHECKROLE:SUPER ADMIN ==========
    Route::middleware(['checkrole:Super Admin'])->group(function () {
        // Halaman user (resource biasa)
        Route::resource('user', UserController::class);

        // CRUD Data Warga
        Route::resource('warga', WargaController::class);
    });

    // Route lain yang hanya perlu checkislogin (tanpa checkrole:admin)
    // CRUD Data Penduduk
    Route::resource('penduduk', PendudukController::class);

    // CRUD Data Keluarga KK
    Route::resource('keluargakk', KeluargaKKController::class);

    // ========== MODUL KEPENDUDUKAN - PERISTIWA VITAL ==========
    // Peristiwa Kelahiran
    Route::resource('peristiwa-kelahiran', PeristiwaKelahiranController::class);
    Route::post('peristiwa-kelahiran/{id}/upload-files', [\App\Http\Controllers\PeristiwaKelahiranController::class, 'uploadFiles'])->name('peristiwa-kelahiran.upload-files');
    Route::delete('peristiwa-kelahiran/{id}/delete-file/{mediaId}', [\App\Http\Controllers\PeristiwaKelahiranController::class, 'deleteFile'])->name('peristiwa-kelahiran.delete-file');

    // Peristiwa Kematian
    Route::resource('peristiwa-kematian', PeristiwaKematianController::class);
    Route::post('peristiwa-kematian/{id}/upload-files', [\App\Http\Controllers\PeristiwaKematianController::class, 'uploadFiles'])->name('peristiwa-kematian.upload-files');
    Route::delete('peristiwa-kematian/{id}/delete-file/{mediaId}', [\App\Http\Controllers\PeristiwaKematianController::class, 'deleteFile'])->name('peristiwa-kematian.delete-file');
    // =========================================================

    // Multiple Uploads (jika sudah ada)
    Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])->name('uploads');
    Route::post('/save', [MultipleuploadsController::class, 'store'])->name('uploads.store');

    // Identitas Pengembang
    Route::get('/identitas-pengembang', function () {
        return view('pages.identitas-pengembang');
    })->name('identitas-pengembang');
});
