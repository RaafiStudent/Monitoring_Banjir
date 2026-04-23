<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class FloodController extends Controller
{
    public function index()
    {
        // Ambil data terbaru
        $latestData = SensorData::latest()->first() ?? new SensorData([
            'water_level' => 0, 'status' => 'AMAN', 'rain_status' => 'Cerah', 'water_flow' => 0
        ]);

        // Ambil 6 data terakhir untuk Chart.js
        $historyData = SensorData::latest()->take(6)->get()->reverse();

        // Logika warna badge & card
        $status = strtoupper($latestData->status);
        $badgeClass = match($status) {
            'SIAGA'  => 'bg-amber-500 text-slate-900 shadow-[0_0_25px_rgba(245,158,11,0.5)]',
            'BAHAYA' => 'bg-rose-600 text-white shadow-[0_0_25px_rgba(225,29,72,0.5)]',
            default  => 'bg-emerald-500 text-white shadow-[0_0_25px_rgba(16,185,129,0.5)]',
        };

        $cardClass = match($status) {
            'SIAGA'  => 'bg-gradient-to-br from-amber-500 to-orange-600 shadow-orange-500/30',
            'BAHAYA' => 'bg-gradient-to-br from-rose-500 to-red-600 shadow-rose-500/30',
            default  => 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-emerald-500/30',
        };

        return view('welcome', compact('latestData', 'historyData', 'badgeClass', 'cardClass'));
    }

    // Fungsi API untuk alat IoT Nabila
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'water_level' => 'required|numeric',
            'rain_status' => 'nullable|string',
            'water_flow'  => 'nullable|numeric',
            'status'      => 'required|string',
        ]);

        SensorData::create($validated);
        return response()->json(['message' => 'Data Terkirim ke Cloud'], 201);
    }
}