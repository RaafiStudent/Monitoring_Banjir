<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data terbaru untuk kartu ringkasan
        $latestData = SensorData::latest()->first() ?? new SensorData([
            'water_level' => 0, 'status' => 'NORMAL', 'created_at' => now()
        ]);

        // Data riwayat untuk tabel (limit 10)
        $logs = SensorData::latest()->paginate(10);

        // Statistik ringkas
        $stats = [
            'total_logs' => SensorData::count(),
            'danger_count' => SensorData::where('status', 'BAHAYA')->count(),
            'avg_level' => round(SensorData::avg('water_level') ?? 0, 1),
        ];

        return view('dashboard', compact('latestData', 'logs', 'stats'));
    }
}