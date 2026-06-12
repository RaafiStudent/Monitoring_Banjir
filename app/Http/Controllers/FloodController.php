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

        // --- TAMBAHAN FITUR HUJAN ---
        // 1. Tangkap angka curah hujan (Default 0 jika alat IoT belum ngirim)
        $rain_value = $request->rain_value ?? 0;

        // 2. Tentukan Teks Status Hujan Otomatis berdasarkan Angka
        $rain_status = 'CERAH';
        if ($rain_value > 0 && $rain_value <= 10) {
            $rain_status = 'GERIMIS';
        } elseif ($rain_value > 10 && $rain_value <= 30) {
            $rain_status = 'HUJAN SEDANG';
        } elseif ($rain_value > 30) {
            $rain_status = 'HUJAN LEBAT';
        }
        // ----------------------------

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
            'rain_value' => $rain_value,     // Disimpan ke DB
            'rain_status' => $rain_status,   // Disimpan ke DB
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
                'status' => $status,
                'rain_value' => $rain_value,
                'rain_status' => $rain_status
            ]
        ], 200);
    }

    public function exportPdf()
{
    // 1. Sistem mengambil data monitoring yang tersimpan pada basis data
    $data = SensorData::orderBy('created_at', 'desc')->get();

    // 2. Tahap Percabangan (Decision): Sistem memeriksa ketersediaan data
    if ($data->isEmpty()) {
        // JIKA TIDAK TERSEDIA: Sistem menampilkan pesan bahwa laporan tidak dapat dibuat
        return redirect()->back()->with('error', 'Laporan gagal diekspor: Data monitoring saat ini tidak tersedia atau kosong.');
    }

    // JIKA TERSEDIA: Sistem membuat dokumen PDF dan menampilkan hasil laporan
    // Kita mengirim variabel $data ke dalam file desain PDF
    $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));

    // 3. Mengunduh file PDF ke perangkat pengguna
    return $pdf->download('Laporan-Monitoring-Banjir-Kaligangsa.pdf');
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
        $thresholds = Threshold::first(); // Ambil data ambang batas

        return response()->json([
            'latest' => $latest,
            'thresholds' => $thresholds, // Kirim ke frontend
            'history' => $history->map(function($item) {
                return [
                    'time' => \Carbon\Carbon::parse($item->created_at)->format('H:i:s'),
                    'level' => $item->water_level
                ];
            })
        ]);
    }
}