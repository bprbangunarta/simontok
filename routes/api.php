<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProspekController;
use App\Http\Controllers\Api\TugasController;
use App\Http\Controllers\Api\VerifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::put('/tugas/{notugas}', [TugasController::class, 'update']);
Route::post('/tugas/upload', [TugasController::class, 'upload']);

Route::put('/verifikasi/kredit/{notugas}', [VerifikasiController::class, 'update']);
Route::post('/verifikasi/upload', [VerifikasiController::class, 'upload']);

Route::post('/verifikasi/agunan/{noreg}', [VerifikasiController::class, 'store']);
Route::put('/verifikasi/agunan/{noreg}', [VerifikasiController::class, 'agunan']);

// Route::post('/prospek', [ProspekController::class, 'store']);
// Route::put('/prospek/{prospek}', [ProspekController::class, 'update']);
Route::post('/prospek/upload', [ProspekController::class, 'upload']);
