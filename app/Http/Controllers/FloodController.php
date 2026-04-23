<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class FloodController extends Controller
{
    public function index()
    {
        // Ambil data terbaru dari sensor
        $latestData = SensorData::latest()->first() ?? new SensorData([
            'water_level' => 0,
            'rain_status' => 'Tidak Hujan',
            'water_flow' => 0,
            'status' => 'Aman'
        ]);

        // Logika warna Dashboard Visual Adaptif
        $bgColor = match($latestData->status) {
            'Siaga' => 'bg-orange-500',
            'Bahaya' => 'bg-red-600',
            default => 'bg-green-500',
        };

        return view('welcome', compact('latestData', 'bgColor'));
    }
}