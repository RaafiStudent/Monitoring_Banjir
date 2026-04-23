<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-wide">
            {{ __('Command Center BPBD Tegal') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-600 rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-cyan-500 rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-6 rounded-[2rem] shadow-2xl">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Elevasi Saat Ini</p>
                    <h3 class="text-4xl font-black text-white">{{ $latestData->water_level }} <span class="text-sm text-cyan-400">cm</span></h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full animate-pulse bg-cyan-400"></span>
                        <span class="text-[10px] font-bold text-cyan-400 uppercase">Real-time Sync</span>
                    </div>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-6 rounded-[2rem] shadow-2xl">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Status Sistem</p>
                    <h3 class="text-2xl font-black {{ $latestData->status == 'BAHAYA' ? 'text-rose-500' : ($latestData->status == 'SIAGA' ? 'text-amber-500' : 'text-emerald-400') }}">
                        {{ strtoupper($latestData->status) }}
                    </h3>
                    <p class="text-[10px] text-slate-500 mt-4">Diperbarui: {{ \Carbon\Carbon::parse($latestData->created_at)->format('H:i:s') }}</p>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-6 rounded-[2rem] shadow-2xl">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Insiden Bahaya</p>
                    <h3 class="text-4xl font-black text-rose-500">{{ $stats['danger_count'] }} <span class="text-sm text-slate-500">Record</span></h3>
                    <p class="text-[10px] text-slate-500 mt-4">Total kumulatif status awas.</p>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-6 rounded-[2rem] shadow-2xl">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Total Log Sensor</p>
                    <h3 class="text-4xl font-black text-cyan-400">{{ $stats['total_logs'] }}</h3>
                    <p class="text-[10px] text-slate-500 mt-4">Database: MySQL Terintegrasi</p>
                </div>
            </div>

            <div class="bg-slate-900/40 backdrop-blur-2xl border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-white">Log Riwayat Sensor</h3>
                        <p class="text-slate-500 text-sm mt-1">Data digital yang dikirimkan oleh ESP32-DEVKIT Nabila.</p>
                    </div>
                    <div class="flex gap-3">
                        <button class="bg-white hover:bg-slate-200 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold transition-all transform hover:-translate-y-1 shadow-lg">
                            Ekspor PDF
                        </button>
                        <button class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                            Kirim Broadcast WA
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] bg-slate-900/60">
                                <th class="px-8 py-5 font-bold">Timestamp</th>
                                <th class="px-8 py-5 font-bold text-center">Ketinggian Air</th>
                                <th class="px-8 py-5 font-bold text-center">Status</th>
                                <th class="px-8 py-5 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse($logs as $log)
                            <tr class="hover:bg-white/5 transition-all group">
                                <td class="px-8 py-6 text-sm text-slate-300 font-medium">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }} 
                                    <span class="text-slate-600 ml-2">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}</span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-black text-white">{{ $log->water_level }}</span>
                                    <span class="text-xs text-slate-500 font-bold ml-1">CM</span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-widest border
                                        {{ $log->status == 'BAHAYA' ? 'bg-rose-500/10 text-rose-500 border-rose-500/20' : 
                                           (in_array($log->status, ['SIAGA', 'SIAGA 2']) ? 'bg-amber-500/10 text-amber-500 border-amber-500/20' : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20') }}">
                                        {{ strtoupper($log->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <button class="text-slate-500 hover:text-cyan-400 transition-colors" title="Detail">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-slate-600 italic font-medium">Menunggu transmisi data dari ESP32...</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-900/20 border-t border-slate-800">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>