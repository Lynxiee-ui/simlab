<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AuthController;

// ================= HALAMAN PERTAMA = LOGIN DOSEN =================
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role == 'dosen') {
            return redirect()->route('dosen.modul3');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ================= LOGIN ADMIN =================
Route::get('/admin/login', [AuthController::class, 'showLoginAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login.post');

// ================= LOGIN & REGISTER DOSEN =================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ================= LOGOUT =================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ROUTE YANG WAJIB LOGIN =================
Route::middleware(['auth'])->group(function () {

    // -------- ADMIN --------
    Route::get('/dashboard', [ModulController::class, 'dashboard'])->name('dashboard');

    Route::get('/modul2/lisensi', [ModulController::class, 'indexLisensi'])->name('modul2.lisensi');
    Route::post('/modul2/lisensi/store', [ModulController::class, 'storeLisensi'])->name('modul2.store');
    Route::put('/modul2/lisensi/{id}', [ModulController::class, 'updateLisensi'])->name('modul2.update');
    Route::delete('/modul2/lisensi/{id}', [ModulController::class, 'destroyLisensi'])->name('modul2.destroy');

    Route::get('/modul3/pengajuan', [ModulController::class, 'indexPengajuan'])->name('modul3.pengajuan');
    Route::post('/modul3/pengajuan/store', [ModulController::class, 'storePengajuan'])->name('modul3.store');
    Route::put('/modul3/pengajuan/{id}', [ModulController::class, 'updatePengajuan'])->name('modul3.update');
    Route::delete('/modul3/pengajuan/{id}', [ModulController::class, 'destroyPengajuan'])->name('modul3.destroy');
    Route::patch('/modul3/pengajuan/{id}/status', [ModulController::class, 'updateStatusPengajuan'])->name('modul3.status');

    Route::get('/modul5/jadwal', [ModulController::class, 'indexJadwal'])->name('modul5.jadwal');
    Route::post('/modul5/jadwal/store', [ModulController::class, 'storeJadwal'])->name('modul5.store');
    Route::put('/modul5/jadwal/{id}', [ModulController::class, 'updateJadwal'])->name('modul5.update');
    Route::delete('/modul5/jadwal/{id}', [ModulController::class, 'destroyJadwal'])->name('modul5.destroy');

    Route::get('/modul6/laporan', [ModulController::class, 'indexLaporan'])->name('modul6.laporan');
    Route::post('/modul6/laporan/store', [ModulController::class, 'storeLaporan'])->name('modul6.store');
    Route::put('/modul6/laporan/{id}', [ModulController::class, 'updateLaporan'])->name('modul6.update');
    Route::delete('/modul6/laporan/{id}', [ModulController::class, 'destroyLaporan'])->name('modul6.destroy');

    Route::get('/modul7/sop', [ModulController::class, 'indexSop'])->name('modul7.sop');
    Route::post('/modul7/sop/store', [ModulController::class, 'storeSop'])->name('modul7.store');
    Route::put('/modul7/sop/{id}', [ModulController::class, 'updateSop'])->name('modul7.update');
    Route::delete('/modul7/sop/{id}', [ModulController::class, 'destroySop'])->name('modul7.destroy');
    Route::get('/modul7/sop/download/{id}', [ModulController::class, 'downloadSop'])->name('modul7.download');

    // -------- DOSEN --------
    Route::get('/dosen/pengajuan', [DosenController::class, 'indexModul3'])->name('dosen.modul3');
    Route::post('/dosen/pengajuan/store', [DosenController::class, 'storeModul3'])->name('dosen.modul3.store');
    Route::get('/dosen/sop', [DosenController::class, 'indexModul7'])->name('dosen.modul7');
    Route::get('/dosen/sop/download/{id}', [DosenController::class, 'downloadModul7'])->name('dosen.modul7.download');
});