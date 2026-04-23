<?php

use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FloodController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';