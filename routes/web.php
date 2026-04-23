<?php

use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;

// Halaman Landing Page Utama (Bisa diakses tanpa login)
Route::get('/', [FloodController::class, 'index'])->name('home');

// Route bawaan Breeze (Halaman Admin, wajib login)
Route::get('/dashboard-admin', function () {
    return view('dashboard'); // Pastikan nanti kamu punya view dashboard khusus admin jika ini dipakai
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';