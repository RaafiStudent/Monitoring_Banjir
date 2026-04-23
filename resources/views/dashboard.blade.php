@extends('layouts.landing')

@section('content')
    <section id="home" class="relative pt-32 pb-24 lg:pt-52 lg:pb-40 overflow-hidden bg-[#111827] text-white flex flex-col justify-center min-h-screen">
        <div class="w-full max-w-[90rem] mx-auto text-center px-4 md:px-8 relative z-10 flex flex-col items-center">
            
            <div id="badge-status-container" class="inline-flex items-center gap-2 px-6 py-2 rounded-full text-slate-900 text-sm font-bold mb-8 transition-all duration-500 bg-emerald-400">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                </span>
                <span id="badge-status-text">STATUS: MEMUAT...</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-[6.5rem] font-black tracking-tight leading-[1.1] mb-8 text-white">
                Sistem Peringatan <br>
                <span class="text-cyan-400 text-glow block mt-2">Banjir Kaligangsa</span>
            </h1>
            
            <p class="text-lg lg:text-xl text-slate-400 mb-12 max-w-3xl mx-auto font-light leading-relaxed">
                Platform monitoring data ketinggian air real-time untuk perencanaan dan penanggulangan potensi banjir.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-5 mb-12">
                <a href="#monitoring" class="px-8 py-3.5 text-base font-bold text-slate-900 bg-white rounded-xl hover:-translate-y-1 transition-transform">Analisis Dashboard</a>
                <a href="#info" class="px-8 py-3.5 text-base font-bold text-white bg-transparent border border-slate-600 rounded-xl hover:bg-slate-800 transition-colors">Lihat Instruksi</a>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[60px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,119.3,197.6,104.14,242.45,93.9,282.8,72.48,321.39,56.44Z" fill="#F8FAFC"></path>
            </svg>
        </div>
    </section>

    <section id="monitoring" class="py-20 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Visualisasi Data</h2>
                    <p id="last-sync" class="text-slate-500 mt-1 font-medium text-lg">Menghubungkan ke sensor...</p>
                </div>
                <div class="flex items-center gap-2 bg-emerald-100/50 text-emerald-600 px-4 py-2 rounded-lg font-bold text-sm border border-emerald-200">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    Sistem Online
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-[1.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-bold text-lg text-slate-800">Tren Ketinggian Air (Sensor)</h3>
                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">Satuan: CM</span>
                    </div>
                    <div class="relative h-[300px] w-full">
                        <canvas id="chart"></canvas>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 flex items-center gap-5">
                        <div class="w-14 h-14 bg-cyan-50 rounded-xl text-cyan-500 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Elevasi Permukaan</p>
                            <h3 id="water-level-display" class="text-4xl font-black text-slate-800 mt-1">0 <span class="text-lg font-bold text-slate-400">cm</span></h3>
                        </div>
                    </div>

                    <div id="status-card" class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-[1.5rem] shadow-xl p-6 text-white relative overflow-hidden transition-all duration-500">
                        <svg class="absolute -right-4 -top-4 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.83L19.17 19H4.83L12 5.83zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
                        <p class="text-white/80 text-xs font-bold uppercase tracking-wider mb-1 relative z-10">Status Terkini</p>
                        <h3 id="card-status-text" class="text-3xl font-black mb-5 relative z-10">AMAN</h3>
                        <div class="w-full bg-black/20 rounded-full h-2 mb-2 relative z-10">
                            <div id="status-progress" class="bg-white h-2 rounded-full shadow-[0_0_10px_rgba(255,255,255,0.8)] transition-all duration-1000" style="width: 25%"></div>
                        </div>
                        <p class="text-xs font-medium text-white/90 relative z-10">Divalidasi otomatis oleh sistem.</p>
                    </div>

                    <div class="bg-[#111827] rounded-[1.5rem] shadow-xl shadow-slate-900/20 p-6 text-white flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Relay Pompa</p>
                            <h3 class="text-xl font-black mt-1 flex items-center gap-2 text-cyan-400">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping"></span> AKTIF
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-full border-[3px] border-slate-700 border-t-cyan-400 animate-spin"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="info" class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6 text-center">
             <h2 class="text-3xl font-black text-slate-900 mb-12 tracking-tight">Tindakan & Mitigasi Bencana</h2>
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-white p-8 rounded-[1.5rem] border border-slate-100 shadow-xl">
                    <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Potensi Bahaya</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Luapan sungai mencapai jalan utama desa jika hujan terus berlanjut.</p>
                </div>
                <div class="bg-white p-8 rounded-[1.5rem] border border-slate-100 shadow-xl">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Langkah Evakuasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Segera menuju titik kumpul di Balai Desa Kaligangsa.</p>
                </div>
                <div class="bg-white p-8 rounded-[1.5rem] border border-slate-100 shadow-xl">
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Kontak Darurat</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">BPBD Tegal: 112 <br> Posko: 0812-3456-7890</p>
                </div>
             </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Chart
            const ctx = document.getElementById('chart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, "rgba(34, 211, 238, 0.4)"); 
            gradient.addColorStop(1, "rgba(34, 211, 238, 0.0)");   

            window.myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], 
                    datasets: [{
                        label: 'Elevasi (cm)',
                        data: [], 
                        borderColor: '#22d3ee', 
                        backgroundColor: gradient,
                        borderWidth: 4, 
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#22d3ee',
                        pointBorderWidth: 3,
                        pointRadius: 5, 
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, border: { dash: [4, 4] } }
                    }
                }
            });

            // MESIN AUTO-REFRESH
            function fetchRealTimeData() {
                fetch("{{ route('api.latest_data') }}")
                    .then(response => response.json())
                    .then(data => {
                        if(!data.latest) return;
                        
                        // 1. Update Angka Elevasi
                        document.getElementById('water-level-display').innerHTML = data.latest.water_level + ' <span class="text-lg font-bold text-slate-400">cm</span>';
                        
                        // 2. Update Teks Status
                        let statusText = data.latest.status.toUpperCase();
                        document.getElementById('badge-status-text').innerText = 'STATUS: ' + statusText;
                        document.getElementById('card-status-text').innerText = statusText;
                        
                        // 3. Update Visual (Warna & Progress Bar)
                        let badge = document.getElementById('badge-status-container');
                        let card = document.getElementById('status-card');
                        let progress = document.getElementById('status-progress');
                        
                        // Bersihkan class lama
                        badge.className = 'inline-flex items-center gap-2 px-6 py-2 rounded-full text-sm font-bold mb-8 transition-all duration-500 ';
                        card.className = 'rounded-[1.5rem] shadow-xl p-6 text-white relative overflow-hidden transition-all duration-500 ';

                        if (statusText === 'BAHAYA') {
                            badge.classList.add('bg-rose-500', 'text-white', 'shadow-[0_0_20px_rgba(244,63,94,0.5)]');
                            card.classList.add('bg-gradient-to-br', 'from-rose-500', 'to-rose-700', 'shadow-rose-500/30');
                            progress.style.width = '100%';
                        } else if (statusText === 'SIAGA') {
                            badge.classList.add('bg-amber-500', 'text-slate-900', 'shadow-[0_0_20px_rgba(245,158,11,0.5)]');
                            card.classList.add('bg-gradient-to-br', 'from-amber-500', 'to-orange-600', 'shadow-orange-500/30');
                            progress.style.width = '65%';
                        } else {
                            badge.classList.add('bg-emerald-400', 'text-slate-900', 'shadow-[0_0_20px_rgba(52,211,153,0.5)]');
                            card.classList.add('bg-gradient-to-br', 'from-emerald-500', 'to-teal-500', 'shadow-emerald-500/30');
                            progress.style.width = '25%';
                        }
                        
                        // 4. Update Waktu Sync
                        let now = new Date();
                        document.getElementById('last-sync').innerText = 'Sinkronisasi terakhir: ' + now.toLocaleTimeString();
                        
                        // 5. Update Grafik
                        window.myChart.data.labels = data.history.map(item => item.time);
                        window.myChart.data.datasets[0].data = data.history.map(item => item.level);
                        window.myChart.update();
                    });
            }

            // Jalankan setiap 3 detik
            fetchRealTimeData();
            setInterval(fetchRealTimeData, 3000);
        });
    </script>
@endsection