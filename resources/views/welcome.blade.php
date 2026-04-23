<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Banjir - Desa Kaligangsa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-cyan-500 selection:text-white overflow-x-hidden">

    <section id="home" class="relative pt-32 pb-24 lg:pt-52 lg:pb-40 overflow-hidden bg-slate-900 text-white flex flex-col justify-center min-h-screen">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 -z-20"></div>
        
        <div class="w-full max-w-[90rem] mx-auto text-center px-4 md:px-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full {{ $statusColor }} text-white text-sm font-bold mb-8">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                STATUS: {{ strtoupper($latestData->status) }}
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-[6.5rem] font-black tracking-tighter leading-[1.1] mb-8">
                Sistem Peringatan <br>
                <span class="text-cyan-400">Banjir Kaligangsa</span>
            </h1>
            
            <div class="flex justify-center gap-5">
                <a href="#monitoring" class="px-10 py-4 text-lg font-bold text-slate-900 bg-white rounded-2xl transition-all hover:-translate-y-1">Analisis Dashboard</a>
                <a href="{{ route('login') }}" class="px-10 py-4 text-lg font-bold text-white bg-white/5 border border-white/20 rounded-2xl">Login Petugas</a>
            </div>
        </div>
    </section>

    <section id="monitoring" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-xl p-8">
                    <h3 class="font-bold text-xl text-slate-800 mb-8">Tren Ketinggian Air (Real-time)</h3>
                    <div class="relative h-[350px] w-full">
                        <canvas id="chart"></canvas>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl p-8 flex items-center gap-5">
                        <div class="w-16 h-16 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase">Elevasi Permukaan</p>
                            <h3 class="text-5xl font-black text-slate-900">{{ $latestData->water_level }} <span class="text-xl font-bold text-slate-400">cm</span></h3>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-bold uppercase">Relay Pompa</p>
                            <h3 class="text-2xl font-black mt-2 {{ $latestData->water_level > 150 ? 'text-cyan-400' : 'text-slate-500' }}">
                                {{ $latestData->water_level > 150 ? 'AKTIF' : 'STANDBY' }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-full border-4 border-slate-700 {{ $latestData->water_level > 150 ? 'border-t-cyan-400 animate-spin' : '' }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    // Ambil label waktu dari log database
                    labels: {!! json_encode($historyData->pluck('created_at')->map(fn($d) => $d->format('H:i'))) !!},
                    datasets: [{
                        label: 'Elevasi (cm)',
                        data: {!! json_encode($historyData->pluck('water_level')) !!},
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</body>
</html>