<?php

use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Master\AgunanController;
use App\Http\Controllers\Master\KreditController;
use App\Http\Controllers\Master\TelebillingController;
use App\Http\Controllers\Master\WriteoffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/loginApi', [AuthController::class, 'loginApi'])->name('loginApi');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'changeProfile'])->name('change.profile');
    Route::get('/password', [ProfileController::class, 'password'])->name('password');
    Route::post('/password', [ProfileController::class, 'changePassword'])->name('change.password');

    // Administrator
    Route::group(['middleware' => ['role:Super Admin']], function () {
        Route::resource('user', UserController::class)->except(['show']);

        Route::resource('role', RoleController::class)->except(['show', 'create']);
        Route::resource('permission', PermissionController::class)->except(['show', 'create']);

        Route::get('user/{user}/access', [AccessController::class, 'user'])->name('access.user');
        Route::post('user/{user}/access', [AccessController::class, 'update'])->name('access.update');
    });

    // Data Import
    Route::post('import/user', [ImportController::class, 'user'])->name('import.user')->middleware('permission:User Create');
    Route::post('import/kredit', [ImportController::class, 'kredit'])->name('import.kredit')->middleware(['permission:Kredit Update']);
    Route::post('import/tunggakan', [ImportController::class, 'tunggakan'])->name('import.tunggakan')->middleware(['permission:Kredit Update']);
    Route::post('import/writeoff', [ImportController::class, 'writeoff'])->name('import.writeoff')->middleware(['permission:Writeoff Update']);
    Route::post('import/agunan', [ImportController::class, 'agunan'])->name('import.agunan')->middleware(['permission:Agunan Update']);
    Route::post('import/nominatif', [ImportController::class, 'nominatif'])->name('import.nominatif')->middleware(['permission:Kredit Update']);
    Route::post('import/klasifikasi', [ImportController::class, 'klasifikasi'])->name('import.klasifikasi');

    // Data Export
    Route::get('export/user', [ExportController::class, 'user'])->name('export.user')->middleware('permission:User Create');
    Route::get('export/kredit', [ExportController::class, 'kredit'])->name('export.kredit')->middleware(['permission:Kredit Read']);
    Route::get('export/telebilling', [ExportController::class, 'telebilling'])->name('export.telebilling')->middleware(['permission:Telebilling Create']);
    Route::get('export/japo', [ExportController::class, 'japo'])->name('export.japo');
    Route::post('export/tugas', [ExportController::class, 'tugas'])->name('export.tugas');

    // Data Kredit
    Route::get('kredit', [KreditController::class, 'index'])->name('kredit.index')->middleware(['permission:Kredit Read']);
    Route::get('kredit/{nokredit}', [KreditController::class, 'show'])->name('kredit.show')->middleware(['permission:Kredit Read']);
    Route::get('kredit/print/{nokredit}', [KreditController::class, 'print'])->name('kredit.print')->middleware(['permission:Kredit Read']);

    // Data Writeoff
    Route::get('writeoff', [WriteoffController::class, 'index'])->name('writeoff.index')->middleware(['permission:Writeoff Read']);
    Route::get('writeoff/{nokredit}', [WriteoffController::class, 'show'])->name('writeoff.show')->middleware(['permission:Writeoff Read']);
    Route::post('writeoff', [WriteoffController::class, 'store'])->name('writeoff.store')->middleware(['permission:Writeoff Create']);
    Route::get('writeoff/print/{nokredit}', [WriteoffController::class, 'print'])->name('writeoff.print')->middleware(['permission:Writeoff Read']);

    // Data Agunan
    Route::get('agunan', [AgunanController::class, 'index'])->name('agunan.index')->middleware(['permission:Agunan Read']);

    // Data Tugas
    Route::get('tugas', [TugasController::class, 'index'])->name('tugas.index')->middleware(['permission:Tugas Read']);
    Route::get('tugas/create/{nokredit}', [TugasController::class, 'create'])->name('tugas.create')->middleware(['permission:Tugas Create']);
    Route::post('tugas', [TugasController::class, 'store'])->name('tugas.store')->middleware(['permission:Tugas Create']);
    Route::get('tugas/{notugas}/edit', [TugasController::class, 'show'])->name('tugas.show')->middleware(['permission:Tugas Read']);
    Route::put('tugas/{notugas}', [TugasController::class, 'update'])->name('tugas.update')->middleware(['permission:Tugas Update']);
    Route::post('tugas/upload', [TugasController::class, 'upload'])->name('tugas.upload')->middleware(['permission:Tugas Update']);
    Route::delete('tugas/{notugas}', [TugasController::class, 'destroy'])->name('tugas.destroy')->middleware(['permission:Tugas Delete']);
    Route::get('tugas/print/', [TugasController::class, 'print'])->name('tugas.print')->middleware(['permission:Tugas Create|Telebilling Create']);

    // Data Verifikasi
    Route::get('verifikasi/kredit/{notugas}', [VerifikasiController::class, 'show'])->name('verifikasi.show')->middleware(['permission:Verifikasi Read']);
    Route::put('verifikasi/kredit/{notugas}', [VerifikasiController::class, 'update'])->name('verifikasi.update')->middleware(['permission:Verifikasi Update']);
    Route::get('verifikasi/agunan/{noreg}', [VerifikasiController::class, 'agunan'])->name('verifikasi.agunan')->middleware(['permission:Verifikasi Read']);
    Route::post('verifikasi/agunan/{noreg}', [VerifikasiController::class, 'store_agunan'])->name('verifikasi.agunan.store')->middleware(['permission:Verifikasi Update']);
    Route::put('verifikasi/agunan/{verifikasi}', [VerifikasiController::class, 'update_agunan'])->name('verifikasi.agunan')->middleware(['permission:Verifikasi Update']);

    // Data Prospek
    Route::get('prospek', [ProspekController::class, 'index'])->name('prospek.index')->middleware(['permission:Prospek Read']);
    Route::get('prospek/create', [ProspekController::class, 'create'])->name('prospek.create')->middleware(['permission:Prospek Create']);
    Route::post('prospek', [ProspekController::class, 'store'])->name('prospek.store')->middleware(['permission:Prospek Create']);
    Route::get('prospek/{prospek}', [ProspekController::class, 'show'])->name('prospek.show')->middleware(['permission:Prospek Read']);
    Route::put('prospek/{prospek}', [ProspekController::class, 'update'])->name('prospek.update')->middleware(['permission:Prospek Update']);
    Route::post('prospek/upload', [ProspekController::class, 'upload'])->name('prospek.upload')->middleware(['permission:Prospek Update']);
    Route::delete('prospek/{prospek}', [ProspekController::class, 'destroy'])->name('prospek.destroy')->middleware(['permission:Prospek Delete']);

    // Data Telebilling
    Route::get('telebilling', [TelebillingController::class, 'index'])->name('telebilling.index')->middleware(['permission:Telebilling Read']);
    Route::get('telebilling/{nokredit}', [TelebillingController::class, 'show'])->name('telebilling.show')->middleware(['permission:Telebilling Read']);
    Route::post('telebilling', [TelebillingController::class, 'store'])->name('telebilling.store')->middleware(['permission:Telebilling Create']);
});
