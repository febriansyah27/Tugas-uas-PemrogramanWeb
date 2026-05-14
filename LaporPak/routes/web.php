<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController; // <-- Tambahkan ini

Route::get('/', function () {
    return view('welcome');
});

// Route Group khusus yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROUTES WARGA ---
    Route::get('/riwayat-laporan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/buat-laporan', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/buat-laporan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

require __DIR__.'/auth.php';