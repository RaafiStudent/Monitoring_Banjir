<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class FloodController extends Controller
{
    public function index()
    {
        // Ambil data terbaru untuk indikator utama
        $latestData = SensorData::latest()->first() ?? new SensorData([
            'water_level' => 0, 'rain_status' => 'Tidak Hujan', 'water_flow' => 0, 'status' => 'Aman'
        ]);

        // Ambil 10 data terakhir untuk grafik Chart.js
        $historyData = SensorData::latest()->take(10)->get()->reverse();

        // Dashboard Visual Adaptif: Tentukan warna berdasarkan status [cite: 449, 576]
        $statusColor = match($latestData->status) {
            'Siaga' => 'bg-amber-500 shadow-[0_0_25px_rgba(245,158,11,0.5)]',
            'Bahaya' => 'bg-rose-600 shadow-[0_0_25px_rgba(225,29,72,0.5)]',
            default => 'bg-emerald-500 shadow-[0_0_25px_rgba(16,185,129,0.5)]',
        };

        return view('welcome', compact('latestData', 'historyData', 'statusColor'));
    }
}