<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route default (redirect ke login)
Route::get('/', function () {
    return redirect('/login');
});

// Route Auth (sudah otomatis dari Breeze)
require __DIR__.'/auth.php';

// ==================== ROUTE PROFILE (UNTUK SEMUA ROLE) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ROUTE ADMIN ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Siswa - Method di controller adalah 'siswa', 'siswaCreate', dll
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa');  // ← bukan siswaIndex
    Route::get('/siswa/create', [AdminController::class, 'siswaCreate'])->name('siswa.create');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'siswaEdit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');
    
    // Manajemen Guru
    Route::get('/guru', [AdminController::class, 'guru'])->name('guru');
    Route::get('/guru/create', [AdminController::class, 'guruCreate'])->name('guru.create');
    Route::post('/guru', [AdminController::class, 'guruStore'])->name('guru.store');
    Route::delete('/guru/{id}', [AdminController::class, 'guruDestroy'])->name('guru.destroy');
    
    // Manajemen Kelas
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
    Route::get('/kelas/create', [AdminController::class, 'kelasCreate'])->name('kelas.create');
    Route::post('/kelas', [AdminController::class, 'kelasStore'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [AdminController::class, 'kelasEdit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [AdminController::class, 'kelasUpdate'])->name('kelas.update');
    Route::delete('/kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('kelas.destroy');
    
    // Manajemen Jadwal
    Route::get('/jadwal', [AdminController::class, 'jadwal'])->name('jadwal');
    Route::get('/jadwal/create', [AdminController::class, 'jadwalCreate'])->name('jadwal.create');
    Route::post('/jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [AdminController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');
    
    // Laporan
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/kelas/{id}', [AdminController::class, 'laporanKelas'])->name('laporan.kelas');
});

// ==================== ROUTE GURU ====================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelas', [GuruController::class, 'kelasSaya'])->name('kelas');
    Route::get('/absensi', [GuruController::class, 'formAbsensi'])->name('absensi');
    Route::post('/absensi', [GuruController::class, 'simpanAbsensi'])->name('absensi.submit');
    Route::get('/izin', [GuruController::class, 'izin'])->name('izin');
    Route::put('/izin/{id}/{status}', [GuruController::class, 'verifikasiIzin'])->name('izin.verifikasi');
});

// ==================== ROUTE SISWA ====================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi', [SiswaController::class, 'absensi'])->name('absensi');
    Route::get('/absen', [SiswaController::class, 'formAbsen'])->name('absen.form');
    Route::post('/absen', [SiswaController::class, 'simpanAbsen'])->name('absen.simpan');
    Route::get('/izin', [SiswaController::class, 'formIzin'])->name('izin.form');
    Route::post('/izin', [SiswaController::class, 'simpanIzin'])->name('izin.simpan');
    Route::get('/riwayat-izin', [SiswaController::class, 'riwayatIzin'])->name('riwayat-izin');
});