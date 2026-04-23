<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache; // WAJIB TAMBAH INI UNTUK ANTI-SPAM

class FloodController extends Controller
{
    // Tampilan Landing Page
    public function index()
    {
        $latestData = SensorData::latest()->first();
        $historyData = SensorData::latest()->take(6)->get()->reverse();

        return view('dashboard', compact('latestData', 'historyData'));
    }

    // FUNGSI PENERIMA DATA DARI IOT ESP32
    public function storeApi(Request $request)
    {
        $water_level = $request->water_level;
        
        // Logika Status
        $status = 'AMAN';
        if ($water_level >= 100 && $water_level < 150) {
            $status = 'SIAGA';
        } elseif ($water_level >= 150) {
            $status = 'BAHAYA';
        }

        // Simpan ke Database
        $sensorData = SensorData::create([
            'water_level' => $water_level,
            'status' => $status,
        ]);

        // ==========================================
        // LOGIKA BROADCAST WA OTOMATIS (15 MENIT)
        // ==========================================
        if ($status == 'BAHAYA') {
            // Ambil ingatan sistem (Cache), kalau belum ada, set counter = 0
            $broadcastMemory = Cache::get('bahaya_memory', [
                'last_sent' => null, 
                'counter' => 0
            ]);

            $shouldSendWa = false;

            // Jika belum pernah kirim sama sekali
            if (is_null($broadcastMemory['last_sent'])) {
                $shouldSendWa = true;
            } 
            // Jika sudah pernah kirim, cek apakah sudah lewat 15 menit?
            else {
                $minutesPassed = now()->diffInMinutes($broadcastMemory['last_sent']);
                if ($minutesPassed >= 15) {
                    $shouldSendWa = true;
                }
            }

            // Eksekusi Kirim WA
            if ($shouldSendWa) {
                // Tambah hitungan pesan ke-berapa
                $broadcastMemory['counter'] += 1;
                $broadcastMemory['last_sent'] = now();
                
                // Simpan ingatan baru ke Cache (bertahan 24 jam)
                Cache::put('bahaya_memory', $broadcastMemory, now()->addHours(24));

                // Panggil fungsi kirim WA di bawah
                $this->sendEmergencyBroadcast($water_level, $broadcastMemory['counter']);
            }

        } else {
            // JIKA AIR SURUT (Bukan Bahaya Lagi), RESET INGATAN SISTEM KE 0
            if (Cache::has('bahaya_memory')) {
                Cache::forget('bahaya_memory');
            }
        }

        return response()->json(['message' => 'Data IoT berhasil diproses']);
    }

    // FUNGSI KHUSUS KIRIM PESAN KE FONNTE
    private function sendEmergencyBroadcast($level, $peringatanKe)
    {
        // 1. Ambil semua nomor kontak (Warga & Petugas)
        $contacts = Contact::pluck('phone_number')->toArray();
        if(empty($contacts)) return; // Stop kalau belum ada nomor yg didaftarkan
        
        $targetNumbers = implode(',', $contacts);

        // 2. Format Pesan (Dibedakan antara pesan pertama dan pesan update)
        if ($peringatanKe == 1) {
            $pesan = "🚨 *PERINGATAN DINI BENCANA BANJIR* 🚨\n\n"
                   . "Kepada Yth. Warga Desa Kaligangsa,\n"
                   . "Sistem Pemantau Sungai mendeteksi luapan air pada level *BAHAYA*.\n\n"
                   . "🌊 *Ketinggian Air saat ini:* {$level} cm\n"
                   . "📍 *Lokasi:* Desa Kaligangsa\n\n"
                   . "Mohon segera matikan aliran listrik, amankan dokumen penting, dan *segera menuju titik evakuasi* (Balai Desa Kaligangsa). Tim BPBD sedang meluncur ke lokasi.";
        } else {
            $pesan = "⚠️ *INFO UPDATE BANJIR (Peringatan ke-{$peringatanKe})* ⚠️\n\n"
                   . "Air sungai masih terpantau pada level *BAHAYA*.\n"
                   . "🌊 *Ketinggian Air saat ini:* {$level} cm\n\n"
                   . "Bagi warga yang masih berada di rumah, harap segera mengevakuasi diri. Keselamatan jiwa adalah prioritas utama. \n\n"
                   . "_Pesan ini dikirim secara otomatis oleh Sistem Pemantau Banjir BPBD Kota Tegal._";
        }

        // 3. Eksekusi ke API Fonnte
        $token_fonnte = 'TOKEN_WA_KAMU'; // Nanti ganti dengan token aslimu

        Http::withHeaders([
            'Authorization' => $token_fonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumbers,
            'message' => $pesan,
        ]);
    }
}