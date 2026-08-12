<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterDataApiController;
use App\Http\Controllers\Api\PermohonanApiController;
use App\Http\Controllers\Api\PermohonanReportApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/permohonan', [PermohonanApiController::class, 'index']);
    Route::post('/permohonan', [PermohonanApiController::class, 'store']);
    Route::get('/permohonan/{permohonan}', [PermohonanApiController::class, 'show']);
    Route::match(['put', 'patch'], '/permohonan/{permohonan}', [PermohonanApiController::class, 'update']);
    Route::delete('/permohonan/{permohonan}', [PermohonanApiController::class, 'destroy']);
    Route::get('/rekap', [PermohonanReportApiController::class, 'index']);
    Route::get('/master/kecamatan', [MasterDataApiController::class, 'kecamatan']);
    Route::get('/master/desa', [MasterDataApiController::class, 'desa']);
    Route::get('/master/jenis-pelayanan', [MasterDataApiController::class, 'jenisPelayanan']);
});
