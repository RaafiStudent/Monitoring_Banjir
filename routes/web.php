<?php

use App\Http\Controllers\FloodController;
use App\Http\Controllers\DashboardController; // Tambahkan baris ini
use Illuminate\Support\Facades\Route;

// Halaman Landing Page Utama (Publik)
Route::get('/', [FloodController::class, 'index'])->name('home');

// Halaman Dashboard Admin BPBD (Wajib Login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/auth.php';