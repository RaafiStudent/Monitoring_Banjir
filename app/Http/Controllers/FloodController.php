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
    /**
     * Menampilkan Landing Page Publik.
     */
    public function index()
    {
        // Ambil data terbaru untuk Hero Section
        $latestData = SensorData::latest()->first();

        // Ambil 6 data terakhir untuk Grafik Chart.js
        $historyData = SensorData::latest()->take(6)->get()->reverse();

        return view('dashboard', compact('latestData', 'historyData'));
    }

    /**
     * Menerima transmisi data dari Alat IoT (ESP32).
     * Jalur: POST /api/update-sensor
     */
    public function storeApi(Request $request)
    {
        // 1. Tangkap data ketinggian air dari request IoT
        $water_level = $request->water_level;

        // 2. Ambil Ambang Batas dari Database secara dinamis
        $threshold = Threshold::first();
        $batasSiaga = $threshold ? $threshold->batas_siaga : 100; // Default 100 jika db kosong
        $batasBahaya = $threshold ? $threshold->batas_bahaya : 150; // Default 150 jika db kosong

        // 3. Tentukan Status berdasarkan Threshold dinamis
        $status = 'AMAN';
        if ($water_level >= $batasSiaga && $water_level < $batasBahaya) {
            $status = 'SIAGA';
        } elseif ($water_level >= $batasBahaya) {
            $status = 'BAHAYA';
        }

        // 4. Simpan data sensor ke database
        $sensorData = SensorData::create([
            'water_level' => $water_level,
            'status' => $status,
            // Tambahkan field lain jika alatmu mengirim data hujan/debit
            'rain_status' => $request->rain_status ?? 'NORMAL',
            'water_flow' => $request->water_flow ?? 0,
        ]);

        // 5. Logika Peringatan WhatsApp Otomatis (Anti-Spam 15 Menit)
        if ($status == 'BAHAYA') {
            // Cek memori sistem (Cache)
            $broadcastMemory = Cache::get('bahaya_memory', [
                'last_sent' => null, 
                'counter' => 0
            ]);

            $shouldSendWa = false;

            // Jika belum pernah kirim atau sudah lewat 15 menit dari kiriman terakhir
            if (is_null($broadcastMemory['last_sent'])) {
                $shouldSendWa = true;
            } else {
                $minutesPassed = now()->diffInMinutes($broadcastMemory['last_sent']);
                if ($minutesPassed >= 15) {
                    $shouldSendWa = true;
                }
            }

            // Eksekusi pengiriman jika memenuhi syarat
            if ($shouldSendWa) {
                $broadcastMemory['counter'] += 1;
                $broadcastMemory['last_sent'] = now();
                
                // Simpan update memori ke Cache (berlaku 24 jam)
                Cache::put('bahaya_memory', $broadcastMemory, now()->addHours(24));

                // Kirim Broadcast
                $this->sendEmergencyBroadcast($water_level, $broadcastMemory['counter']);
            }

        } else {
            // JIKA STATUS TURUN (SURUT), Reset hitungan peringatan kembali ke 0
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

    /**
     * Fungsi Internal untuk mem-blast pesan ke WhatsApp Gateway (Fonnte).
     */
    private function sendEmergencyBroadcast($level, $peringatanKe)
    {
        // Ambil semua nomor dari tabel kontak
        $contacts = Contact::pluck('phone_number')->toArray();
        if (empty($contacts)) return;
        
        $targetNumbers = implode(',', $contacts);

        // Bedakan pesan berdasarkan urutan (Peringatan pertama vs Update)
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

        // Token Fonnte (Silakan ganti dengan token aslimu dari dashboard fonnte.com)
        $token_fonnte = 'TOKEN_WA_KAMU_DISINI'; 

        Http::withHeaders([
            'Authorization' => $token_fonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumbers,
            'message' => $pesan,
            'delay' => '2', // Jeda antar nomor agar tidak dianggap spam oleh WA
        ]);
    }
}