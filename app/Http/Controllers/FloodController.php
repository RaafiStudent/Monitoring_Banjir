<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\Contact;
use App\Models\Threshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FloodController extends Controller
{
    public function index()
    {
        $latestData = SensorData::latest()->first();
        $historyData = SensorData::latest()->take(6)->get()->reverse();

        return view('dashboard', compact('latestData', 'historyData'));
    }

    public function storeApi(Request $request)
    {
        $water_level = $request->water_level;

        $threshold = Threshold::first();
        $batasSiaga = $threshold ? $threshold->batas_siaga : 100; 
        $batasBahaya = $threshold ? $threshold->batas_bahaya : 150; 

        $status = 'AMAN';
        if ($water_level >= $batasSiaga && $water_level < $batasBahaya) {
            $status = 'SIAGA';
        } elseif ($water_level >= $batasBahaya) {
            $status = 'BAHAYA';
        }

        $sensorData = SensorData::create([
            'water_level' => $water_level,
            'status' => $status,
            'rain_status' => $request->rain_status ?? 'NORMAL',
            'water_flow' => $request->water_flow ?? 0,
        ]);

        if ($status == 'BAHAYA') {
            $broadcastMemory = Cache::get('bahaya_memory', [
                'last_sent' => null, 
                'counter' => 0
            ]);

            $shouldSendWa = false;

            if (is_null($broadcastMemory['last_sent'])) {
                $shouldSendWa = true;
            } else {
                $minutesPassed = now()->diffInMinutes($broadcastMemory['last_sent']);
                if ($minutesPassed >= 15) {
                    $shouldSendWa = true;
                }
            }

            if ($shouldSendWa) {
                $broadcastMemory['counter'] += 1;
                $broadcastMemory['last_sent'] = now();
                
                Cache::put('bahaya_memory', $broadcastMemory, now()->addHours(24));

                $this->sendEmergencyBroadcast($water_level, $broadcastMemory['counter']);
            }

        } else {
            if (Cache::has('bahaya_memory')) {
                Cache::forget('bahaya_memory');
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data processed successfully',
            'data' => [
                'level' => $water_level,
                'status' => $status
            ]
        ], 200);
    }

    private function sendEmergencyBroadcast($level, $peringatanKe)
    {
        $contacts = Contact::pluck('phone_number')->toArray();
        if (empty($contacts)) return;
        
        $targetNumbers = implode(',', $contacts);

        if ($peringatanKe == 1) {
            $pesan = "🚨 *PERINGATAN DINI BANJIR - DESA KALIGANGSA* 🚨\n\n"
                   . "Sistem mendeteksi air pada level *BAHAYA*.\n"
                   . "🌊 *Ketinggian Air:* {$level} cm\n\n"
                   . "Warga diminta segera mematikan listrik dan mengevakuasi diri ke Balai Desa. Jangan menunggu air masuk ke rumah!";
        } else {
            $pesan = "⚠️ *UPDATE STATUS BANJIR (Pesan ke-{$peringatanKe})* ⚠️\n\n"
                   . "Kondisi air sungai masih berada pada level *BAHAYA*.\n"
                   . "🌊 *Ketinggian Air:* {$level} cm\n\n"
                   . "Tetap waspada dan ikuti instruksi petugas BPBD di lapangan.";
        }

        $token_fonnte = 'TOKEN_WA_KAMU_DISINI'; 

        Http::withHeaders([
            'Authorization' => $token_fonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumbers,
            'message' => $pesan,
            'delay' => '2',
        ]);
    }

    /**
     * Endpoint untuk menarik data terbaru ke layar secara Real-time (AJAX)
     */
    public function getLatestData()
    {
        $latest = SensorData::latest()->first();
        $history = SensorData::latest()->take(6)->get()->reverse()->values();

        return response()->json([
            'latest' => $latest,
            'history' => $history->map(function($item) {
                return [
                    'time' => \Carbon\Carbon::parse($item->created_at)->format('H:i:s'),
                    'level' => $item->water_level
                ];
            })
        ]);
    }
}