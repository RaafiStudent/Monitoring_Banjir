<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\Contact;
use App\Models\Threshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Tangkap angka curah hujan (Default 0 jika alat IoT belum ngirim)
        $rain_value = $request->rain_value ?? 0;

        // Tentukan Teks Status Hujan Otomatis berdasarkan Angka
        $rain_status = 'CERAH';
        if ($rain_value > 0 && $rain_value <= 10) {
            $rain_status = 'GERIMIS';
        } elseif ($rain_value > 10 && $rain_value <= 30) {
            $rain_status = 'HUJAN SEDANG';
        } elseif ($rain_value > 30) {
            $rain_status = 'HUJAN LEBAT';
        }

        $threshold = Threshold::first();
        // Default value jika belum di-set di database
        $batasWaspada = $threshold ? $threshold->batas_waspada : 50; 
        $batasSiaga = $threshold ? $threshold->batas_siaga : 100; 
        $batasBahaya = $threshold ? $threshold->batas_bahaya : 150; 

        // Penentuan 4 Status
        $status = 'AMAN';
        if ($water_level >= $batasBahaya) {
            $status = 'BAHAYA';
        } elseif ($water_level >= $batasSiaga) {
            $status = 'SIAGA';
        } elseif ($water_level >= $batasWaspada) {
            $status = 'WASPADA';
        }

        // Simpan semua data ke database (Termasuk data hujan)
        $sensorData = SensorData::create([
            'water_level' => $water_level,
            'status' => $status,
            'rain_value' => $rain_value,     
            'rain_status' => $rain_status,   
            'water_flow' => $request->water_flow ?? 0,
        ]);

        // CEK STATUS SAKLAR: Apakah Peringatan Dini sedang diaktifkan oleh Admin?
        $isWarningActive = Cache::get('is_warning_active', true);

        // Hanya kirim WA Otomatis jika status BAHAYA dan Saklar AKTIF
        if ($status == 'BAHAYA' && $isWarningActive) {
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
                'status' => $status,
                'rain_value' => $rain_value,
                'rain_status' => $rain_status
            ]
        ], 200);
    }

    // FUNGSI SAKLAR ON/OFF PERINGATAN DINI
    public function toggleWarning()
    {
        $currentState = Cache::get('is_warning_active', true);
        $newState = !$currentState; // Balikkan status
        Cache::put('is_warning_active', $newState);

        $pesan = $newState ? 'Sistem Peringatan Dini berhasil diaktifkan!' : 'Sistem Peringatan Dini berhasil dinonaktifkan sementara.';
        return redirect(url()->previous() . '#monitoring')->with('success', $pesan);
    }

    // FUNGSI EKSPOR PDF DENGAN PERCABANGAN (DECISION)
    public function exportPdf()
    {
        $data = SensorData::orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            return redirect(url()->previous() . '#monitoring')
                ->with('error', 'Laporan gagal diekspor: Data monitoring saat ini tidak tersedia atau kosong.');
        }

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download('Laporan-Monitoring-Banjir-Kaligangsa.pdf');
    }

    // FUNGSI BROADCAST MANUAL ADMIN
    public function manualBroadcast()
    {
        $latestData = SensorData::latest()->first();
        $level = $latestData ? $latestData->water_level : 0;
        
        $contacts = Contact::pluck('phone_number')->toArray();
        if (empty($contacts)) {
            return redirect(url()->previous() . '#monitoring')->with('error', 'Gagal: Belum ada kontak terdaftar di sistem.');
        }

        $targetNumbers = implode(',', $contacts);
        
        $pesan = "📢 *INFORMASI BPBD KOTA TEGAL* 📢\n\n"
               . "Pesan imbauan langsung dari Command Center.\n"
               . "🌊 *Ketinggian Air Terkini:* {$level} cm\n\n"
               . "Kondisi cuaca dan aliran air sedang dalam pantauan. Harap warga tetap waspada dan persiapkan langkah mitigasi mandiri.";

        $token_fonnte = env('FONNTE_TOKEN', 'TOKEN_WA_KAMU_DISINI'); 

        $response = Http::withHeaders([
            'Authorization' => $token_fonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumbers,
            'message' => $pesan,
            'delay' => '2',
        ]);

        if ($response->successful()) {
            return redirect(url()->previous() . '#monitoring')->with('success', 'Broadcast WhatsApp berhasil dikirim ke seluruh kontak!');
        } else {
            return redirect(url()->previous() . '#monitoring')->with('error', 'Gagal mengirim WA: Periksa token API atau koneksi internet.');
        }
    }

    // BROADCAST OTOMATIS
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

        $token_fonnte = env('FONNTE_TOKEN', 'TOKEN_WA_KAMU_DISINI'); 

        Http::withHeaders([
            'Authorization' => $token_fonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumbers,
            'message' => $pesan,
            'delay' => '2',
        ]);
    }

    public function getLatestData()
    {
        $latest = SensorData::latest()->first();
        $history = SensorData::latest()->take(6)->get()->reverse()->values();
        $thresholds = Threshold::first(); 

        return response()->json([
            'latest' => $latest,
            'thresholds' => $thresholds, 
            'history' => $history->map(function($item) {
                return [
                    'time' => \Carbon\Carbon::parse($item->created_at)->format('H:i:s'),
                    'level' => $item->water_level
                ];
            })
        ]);
    }
}