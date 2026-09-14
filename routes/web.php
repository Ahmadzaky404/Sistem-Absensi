<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LokasiAbsenController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\RiwayatAbsensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'direktur_utama' => redirect()->route('dirut.dashboard'),
        'direktur' => redirect()->route('direktur.dashboard'),
        'office_boy' => redirect()->route('office-boy.dashboard'),
        'karyawan' => redirect()->route('karyawan.dashboard'),
        default => redirect()->route('admin.dashboard'),
    };
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
    Route::get('/karyawan/login', [AuthController::class, 'showKaryawanLogin'])->name('karyawan.login');
    Route::post('/karyawan/login', [AuthController::class, 'loginKaryawan'])->middleware('throttle:5,1')->name('karyawan.login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dirut/dashboard', [KaryawanDashboardController::class, 'index'])->name('dirut.dashboard');
    Route::get('/direktur/dashboard', [KaryawanDashboardController::class, 'index'])->name('direktur.dashboard');
    Route::post('/admin/pengajuan-izin-sakit/{pengajuan}/setujui', [DashboardController::class, 'setujuiPengajuan'])
        ->name('admin.pengajuan-izin-sakit.setujui');
    Route::resource('/admin/karyawan', KaryawanController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.karyawan')
        ->parameters(['karyawan' => 'karyawan']);
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export-excel');
    Route::get('/admin/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('admin.laporan.cetak-pdf');
    Route::resource('/admin/lokasi-absen', LokasiAbsenController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.lokasi-absen');

    Route::get('/karyawan/dashboard', [KaryawanDashboardController::class, 'index'])->name('karyawan.dashboard');
    Route::get('/office-boy/dashboard', [KaryawanDashboardController::class, 'index'])->name('office-boy.dashboard');
    Route::post('/karyawan/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk'])->name('karyawan.absen-masuk');
    Route::post('/karyawan/absen-pulang', [KaryawanDashboardController::class, 'absenPulang'])->name('karyawan.absen-pulang');
    Route::post('/karyawan/pengajuan-izin-sakit', [KaryawanDashboardController::class, 'ajukanIzinSakit'])
        ->name('karyawan.pengajuan-izin-sakit');
    Route::get('/karyawan/riwayat-absensi', [RiwayatAbsensiController::class, 'index'])->name('karyawan.riwayat');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
