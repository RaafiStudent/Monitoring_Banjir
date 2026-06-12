<?php

use App\Http\Controllers\FloodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ThresholdController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [FloodController::class, 'index'])->name('home');
// Rute API AJAX (Real-time)
Route::get('/api/latest-data', [FloodController::class, 'getLatestData'])->name('api.latest_data');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Fitur Ekspor & Broadcast
    Route::get('/admin/laporan/export-pdf', [FloodController::class, 'exportPdf'])->name('admin.export.pdf');
    Route::get('/admin/broadcast/manual', [FloodController::class, 'manualBroadcast'])->name('admin.broadcast.manual');
    Route::get('/admin/warning/toggle', [FloodController::class, 'toggleWarning'])->name('admin.warning.toggle');
    
    // Rute Manajemen Kontak & Threshold
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/threshold', [ThresholdController::class, 'index'])->name('threshold.index');
    Route::post('/threshold/update', [ThresholdController::class, 'update'])->name('threshold.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';