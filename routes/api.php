<?php

use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Endpoint untuk menerima data dari ESP32/Alat IoT
// URL aksesnya nanti: http://127.0.0.1:8000/api/update-sensor
Route::post('/update-sensor', [FloodController::class, 'storeApi']);