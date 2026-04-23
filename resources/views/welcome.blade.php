<x-app-layout>
    <x-slot name="bodyClass">
        bg-slate-50 text-slate-800 antialiased selection:bg-cyan-500 selection:text-white overflow-x-hidden
    </x-slot>

    <section id="home" class="relative pt-32 pb-24 lg:pt-52 lg:pb-40 overflow-hidden bg-brand-950 text-white flex flex-col justify-center min-h-screen">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-brand-950 to-slate-900 -z-20"></div>
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-[100vw] -z-10 overflow-hidden">
            <div class="absolute top-10 left-0 w-[500px] h-[500px] bg-brand-600 rounded-full mix-blend-screen filter blur-[120px] opacity-30"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-cyan-500 rounded-full mix-blend-screen filter blur-[120px] opacity-20"></div>
        </div>

        <div class="w-full max-w-[90rem] mx-auto text-center px-4 md:px-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-amber-500 text-slate-900 text-sm font-bold mb-8 shadow-[0_0_25px_rgba(245,158,11,0.5)]">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                STATUS: SIAGA 2
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-[6.5rem] xl:text-[7.5rem] font-black tracking-tighter leading-[1.1] mb-8 text-white drop-shadow-lg w-full">
                Sistem Peringatan <br class="md:hidden">
                <span class="text-cyan-400 drop-shadow-[0_0_25px_rgba(34,211,238,0.4)] block md:inline mt-2 md:mt-0">Banjir Kaligangsa</span>
            </h1>
            
            <p class="text-lg lg:text-2xl text-slate-300 mb-12 max-w-4xl mx-auto font-light leading-relaxed">
                Platform monitoring data ketinggian air real-time untuk perencanaan dan penanggulangan potensi banjir.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-5 mb-12">
                <a href="#monitoring" class="w-full sm:w-auto px-10 py-4 text-lg font-bold text-slate-900 bg-white hover:bg-slate-100 rounded-2xl shadow-[0_0_30px_rgba(255,255,255,0.15)] transition-all hover:-translate-y-1">Analisis Dashboard</a>
                <a href="#info" class="w-full sm:w-auto px-10 py-4 text-lg font-bold text-white bg-white/5 hover:bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl transition-all">Lihat Instruksi</a>
            </div>

            <div class="flex items-center justify-center gap-2 text-slate-400 font-medium text-sm lg:text-base">
                <svg class="w-5 h-5 text-cyan-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Terakreditasi Resmi oleh BPBD Kota Tegal
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[60px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,119.3,197.6,104.14,242.45,93.9,282.8,72.48,321.39,56.44Z" fill="#f8fafc"></path>
            </svg>
        </div>
    </section>

    <section id="monitoring" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Dashboard Visualisasi Data</h2>
                    <p class="text-slate-500 mt-2 font-medium text-lg">Sinkronisasi terakhir: 2 menit yang lalu</p>
                </div>
                <div class="flex items-center gap-3 bg-emerald-100 text-emerald-700 px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm border border-emerald-200">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    Sistem Online
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/50 p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-bold text-xl text-slate-800">Tren Ketinggian Air (Sensor)</h3>
                        <span class="text-sm font-bold text-brand-700 bg-brand-50 px-4 py-2 rounded-xl border border-brand-100">Satuan: CM</span>
                    </div>
                    <div class="relative h-[350px] w-full">
                        <canvas id="chart"></canvas>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/50 p-8 flex items-center gap-5">
                        <div class="w-16 h-16 bg-cyan-50 rounded-2xl text-cyan-600 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Elevasi Permukaan</p>
                            <h3 class="text-5xl font-black text-slate-900 mt-1">120 <span class="text-xl font-bold text-slate-400">cm</span></h3>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-[2rem] shadow-xl shadow-orange-500/30 p-8 text-white relative overflow-hidden">
                        <svg class="absolute -right-6 -top-6 w-40 h-40 text-white/10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.83L19.17 19H4.83L12 5.83zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
                        
                        <p class="text-amber-100 text-sm font-bold uppercase tracking-wider mb-2 relative z-10">Status Waspada</p>
                        <h3 class="text-4xl font-black mb-6 relative z-10">SIAGA 2</h3>
                        <div class="w-full bg-black/20 rounded-full h-2.5 mb-3 relative z-10">
                            <div class="bg-white h-2.5 rounded-full shadow-[0_0_10px_rgba(255,255,255,0.8)]" style="width: 75%"></div>
                        </div>
                        <p class="text-sm font-medium text-amber-50 relative z-10">Tren naik 15% dari jam sebelumnya.</p>
                    </div>

                    <div class="bg-slate-900 rounded-[2rem] shadow-xl shadow-slate-900/20 p-8 text-white flex items-center justify-between border-2 border-slate-800">
                        <div>
                            <p class="text-slate-400 text-sm font-bold uppercase tracking-wider">Relay Pompa</p>
                            <h3 class="text-2xl font-black mt-2 text-cyan-400 flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-cyan-400 animate-ping"></span> AKTIF
                            </h3>
                        </div>
                        <div class="w-14 h-14 rounded-full border-4 border-slate-700 border-t-cyan-400 animate-spin"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="info" class="py-24 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-16 text-center tracking-tight">Tindakan & Mitigasi Bencana</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-50 p-10 rounded-[2rem] border border-slate-200 hover:border-rose-300 hover:shadow-2xl hover:shadow-rose-100 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-8 group-hover:-translate-y-2 transition-transform duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Potensi Bahaya</h3>
                    <p class="text-slate-600 text-lg leading-relaxed">Terpantau intensitas hujan tinggi di wilayah hulu. Risiko luapan sungai mencapai jalan utama desa dalam waktu dekat.</p>
                </div>
                <div class="bg-slate-50 p-10 rounded-[2rem] border border-slate-200 hover:border-emerald-300 hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-8 group-hover:-translate-y-2 transition-transform duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Langkah Evakuasi</h3>
                    <p class="text-slate-600 text-lg leading-relaxed">Amankan dokumen penting dan matikan aliran listrik. Segera menuju titik kumpul evakuasi di Balai Desa Kaligangsa.</p>
                </div>
                <div class="bg-slate-50 p-10 rounded-[2rem] border border-slate-200 hover:border-cyan-300 hover:shadow-2xl hover:shadow-cyan-100 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center mb-8 group-hover:-translate-y-2 transition-transform duration-300 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Kontak Darurat</h3>
                    <p class="text-slate-600 text-lg leading-relaxed">BPBD Tegal: <span class="font-bold text-slate-900">112</span><br> Posko Siaga Bencana: <span class="font-bold text-slate-900">0812-3456-7890</span></p>
                </div>
            </div>
        </div>
    </section>

    <footer id="tentang" class="bg-brand-950 text-slate-300 py-20 border-t border-slate-800 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            
            <div class="inline-flex items-center justify-center gap-3 px-6 py-3 rounded-full bg-slate-900/50 text-cyan-400 text-sm font-bold mb-8 border border-slate-700 shadow-lg">
                <svg class="w-5 h-5 text-cyan-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Terakreditasi BPBD Kota Tegal
            </div>

            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Sistem Monitoring Penanggulangan Banjir</h2>
            
            <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto mb-12 leading-relaxed">
                Platform perencanaan dan pengembangan visualisasi data terpusat untuk memantau ketinggian air secara real-time guna mendukung upaya mitigasi bencana di Desa Kaligangsa.
            </p>
            
            <div class="h-px w-full max-w-2xl mx-auto bg-gradient-to-r from-transparent via-slate-700 to-transparent mb-10"></div>
            
            <p class="text-slate-500 text-base font-medium tracking-wider uppercase">
                &copy; 2026 Perencanaan dan Pengembangan Sistem. Hak Cipta Dilindungi.
            </p>
        </div>
        
        <div class="absolute bottom-[-100px] left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-cyan-900/20 filter blur-[100px] rounded-full pointer-events-none"></div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chart').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, "rgba(6, 182, 212, 0.4)"); 
            gradient.addColorStop(1, "rgba(6, 182, 212, 0.02)");   

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['06:00', '07:00', '08:00', '09:00', '10:00', '11:00'],
                    datasets: [{
                        label: 'Elevasi (cm)',
                        data: [80, 85, 92, 105, 115, 120],
                        borderColor: '#06b6d4', 
                        backgroundColor: gradient,
                        borderWidth: 5, 
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#06b6d4',
                        pointBorderWidth: 4,
                        pointRadius: 6, 
                        pointHoverRadius: 9,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 16,
                            titleFont: { family: 'Inter', size: 15 },
                            bodyFont: { family: 'Inter', size: 18, weight: 'bold' },
                            displayColors: false,
                            cornerRadius: 12,
                        }
                    },
                    scales: {
                        x: { 
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', weight: 'bold', size: 13 }, color: '#64748b' }
                        },
                        y: { 
                            beginAtZero: true,
                            border: { dash: [6, 6] },
                            grid: { color: '#f1f5f9' }, 
                            ticks: { font: { family: 'Inter', weight: 'bold', size: 13 }, color: '#64748b' }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
</x-app-layout>