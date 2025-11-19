<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\GuruController;
use App\Http\Controllers\SuperAdmin\SiswaController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\MateriController as GuruMateri;
use App\Http\Controllers\Guru\KuisController as GuruKuis;
use App\Http\Controllers\Guru\NilaiController as GuruNilai;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\MateriController as SiswaMateri;
use App\Http\Controllers\Siswa\KuisController as SiswaKuis;

// Redirect root ke login
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Admin Routes
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    
    // Manajemen Guru
    Route::resource('guru', GuruController::class);
    
    // Manajemen Siswa
    Route::resource('siswa', SiswaController::class);
});

// Guru Routes
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
    
    // Manajemen Materi
    Route::resource('materi', GuruMateri::class);
    Route::post('materi/{id}/kosakata', [GuruMateri::class, 'storeKosakata'])->name('materi.kosakata.store');
    Route::delete('materi/{materiId}/kosakata/{kosakatId}', [GuruMateri::class, 'destroyKosakata'])->name('materi.kosakata.destroy');
    
    // Manajemen Kuis
    Route::resource('kuis', GuruKuis::class);
    Route::post('kuis/{id}/soal', [GuruKuis::class, 'storeSoal'])->name('kuis.soal.store');
    Route::delete('kuis/{kuisId}/soal/{soalId}', [GuruKuis::class, 'destroySoal'])->name('kuis.soal.destroy');
    
    // Nilai Siswa
    Route::get('/nilai', [GuruNilai::class, 'index'])->name('nilai.index');
    Route::get('/nilai/siswa/{siswaId}', [GuruNilai::class, 'show'])->name('nilai.siswa');
    Route::get('/nilai/kuis/{kuisId}', [GuruNilai::class, 'perKuis'])->name('nilai.kuis');
    Route::get('/nilai/percobaan/{percobaanId}', [GuruNilai::class, 'detailPercobaan'])->name('nilai.percobaan');
});

// Siswa Routes
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    
    // Materi
    Route::get('/materi', [SiswaMateri::class, 'index'])->name('materi.index');
    Route::get('/materi/{id}', [SiswaMateri::class, 'show'])->name('materi.show');
    
    // Kuis
    Route::get('/kuis', [SiswaKuis::class, 'index'])->name('kuis.index');
    Route::get('/kuis/{id}', [SiswaKuis::class, 'show'])->name('kuis.show');
    Route::post('/kuis/{id}/mulai', [SiswaKuis::class, 'mulai'])->name('kuis.mulai');
    Route::get('/kuis/mengerjakan/{percobaanId}', [SiswaKuis::class, 'mengerjakan'])->name('kuis.mengerjakan');
    Route::post('/kuis/submit/{percobaanId}', [SiswaKuis::class, 'submit'])->name('kuis.submit');
    Route::get('/kuis/hasil/{percobaanId}', [SiswaKuis::class, 'hasil'])->name('kuis.hasil');
});
