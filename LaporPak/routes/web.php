<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'petugas') {
        return redirect()->route('petugas.index');
    }
    return redirect()->route('warga.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// =============================================
// ROUTES WARGA
// =============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/warga/laporan',           [PengaduanController::class, 'index'])      ->name('warga.index');
    Route::get('/warga/laporan/buat',      [PengaduanController::class, 'create'])     ->name('warga.create');
    Route::post('/warga/laporan',          [PengaduanController::class, 'store'])      ->name('warga.store');
    Route::get('/warga/laporan/{id}',      [PengaduanController::class, 'showWarga'])  ->name('warga.show');
    Route::get('/warga/laporan/{id}/cetak',[PengaduanController::class, 'cetakWarga']) ->name('warga.cetak');
});

// =============================================
// ROUTES PETUGAS
// =============================================
Route::middleware(['auth', 'is_petugas'])->group(function () {
    Route::get('/petugas/pengaduan',              [PengaduanController::class, 'indexPetugas']) ->name('petugas.index');
    Route::get('/petugas/pengaduan/export',       [PengaduanController::class, 'export'])       ->name('petugas.export');
    Route::get('/petugas/pengaduan/{id}',         [PengaduanController::class, 'show'])         ->name('petugas.show');
    Route::patch('/petugas/pengaduan/{id}',       [PengaduanController::class, 'update'])       ->name('petugas.update');
    Route::delete('/petugas/pengaduan/{id}',      [PengaduanController::class, 'destroy'])      ->name('petugas.destroy');
    Route::get('/petugas/pengaduan/{id}/cetak',   [PengaduanController::class, 'cetak'])        ->name('petugas.cetak');
    Route::post('/petugas/tanggapan',             [TanggapanController::class, 'store'])        ->name('petugas.tanggapan.store');
    Route::delete('/petugas/tanggapan/{id}',      [TanggapanController::class, 'destroy'])      ->name('petugas.tanggapan.destroy');
});

require __DIR__.'/auth.php';
