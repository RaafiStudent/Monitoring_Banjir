<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FloodMonitor - Kaligangsa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-glow { text-shadow: 0 0 20px rgba(34, 211, 238, 0.6); }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased selection:bg-cyan-500 selection:text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 bg-[#111827]/95 backdrop-blur-md border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 bg-cyan-400 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.4)]">
                        <svg class="w-6 h-6 text-[#111827]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-bold text-xl text-white tracking-wide">FloodMonitor</span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium text-white hover:text-cyan-400 transition-colors">Beranda</a>
                    <a href="#monitoring" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Dashboard</a>
                    <a href="#info" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Informasi</a>
                    <a href="#tentang" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Tentang</a>
                </div>

                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-[#111827] transition-all duration-200 bg-cyan-400 rounded-full hover:bg-cyan-300 shadow-[0_0_15px_rgba(34,211,238,0.5)]">
                        Login Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id="tentang" class="bg-[#111827] text-slate-300 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center justify-center gap-2 px-4 py-1.5 rounded-full bg-slate-800 text-cyan-400 text-xs font-bold mb-6 border border-slate-700 shadow-lg">
                <svg class="w-4 h-4 text-cyan-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Terakreditasi BPBD Kota Tegal
            </div>
            <h2 class="text-3xl font-black text-white mb-4 tracking-tight">Sistem Monitoring Penanggulangan Banjir</h2>
            <p class="text-slate-400 text-sm max-w-2xl mx-auto mb-8 leading-relaxed">
                Platform perencanaan dan pengembangan visualisasi data terpusat untuk memantau ketinggian air secara real-time guna mendukung upaya mitigasi bencana di Desa Kaligangsa.
            </p>
            <div class="h-px w-full max-w-2xl mx-auto bg-gradient-to-r from-transparent via-slate-700 to-transparent mb-8"></div>
            <p class="text-slate-500 text-xs font-medium tracking-wider uppercase">
                &copy; 2026 PERENCANAAN DAN PENGEMBANGAN SISTEM. HAK CIPTA DILINDUNGI.
            </p>
        </div>
    </footer>
</body>
</html>