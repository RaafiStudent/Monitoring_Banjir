<?php

use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Endpoint untuk menerima data dari ESP32/Alat IoT
// URL aksesnya nanti: http://domain-kamu.com/api/update-sensor
Route::post('/update-sensor', [FloodController::class, 'storeApi']);