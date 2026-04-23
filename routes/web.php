<?php

use App\Http\Controllers\FloodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController; // Wajib ditambahkan agar tidak error
use Illuminate\Support\Facades\Route;

// Halaman Landing Page Utama (Publik)
Route::get('/', [FloodController::class, 'index'])->name('home');

// Halaman Dashboard Admin BPBD (Wajib Login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// KUMPULAN RUTE PROFILE (INI YANG MEMPERBAIKI ERRORNYA)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';