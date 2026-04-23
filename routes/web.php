<?php

use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;

// Halaman Landing Page Utama
Route::get('/', [FloodController::class, 'index'])->name('home');

// Route bawaan Breeze (jika kamu ingin menggunakan dashboard admin nantinya)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';