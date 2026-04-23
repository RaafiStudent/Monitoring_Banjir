<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peringatan Banjir - Kaligangsa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-cyan-500 selection:text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-slate-950/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(6,182,212,0.5)]">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-black text-xl text-white tracking-wider">BPBD<span class="text-cyan-400">TEGAL</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-bold text-white hover:text-cyan-400 transition-colors">Beranda</a>
                    <a href="#monitoring" class="text-sm font-bold text-slate-300 hover:text-cyan-400 transition-colors">Data Sensor</a>
                    <a href="#info" class="text-sm font-bold text-slate-300 hover:text-cyan-400 transition-colors">Mitigasi Bencana</a>
                </div>

                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-cyan-500 border border-transparent rounded-full hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                        Login Petugas
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id="tentang" class="bg-slate-950 text-slate-300 py-20 border-t border-slate-800 relative overflow-hidden">
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
</body>
</html>