<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\JenisPelayananController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\PermohonanReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [PasswordController::class, 'showForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/permohonan/recap', [PermohonanReportController::class, 'recap'])->name('permohonan.recap');
    Route::get('/permohonan/export', [PermohonanReportController::class, 'export'])->name('permohonan.export');
    Route::resource('permohonan', PermohonanController::class);
    Route::get('/laporan', function () {
        return response()->json(['message' => 'Menu laporan untuk petugas']);
    })->name('laporan.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Akses admin berhasil']);
    })->name('admin.only');

    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('desa', DesaController::class);
    Route::resource('jenis-pelayanan', JenisPelayananController::class);
    Route::resource('user', UserAdminController::class);
});