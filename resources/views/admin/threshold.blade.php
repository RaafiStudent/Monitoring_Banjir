<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-wide">
            {{ __('Konfigurasi Ambang Batas Air') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen relative overflow-hidden flex items-center justify-center">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-600 rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none"></div>

        <div class="max-w-xl w-full mx-auto sm:px-6 lg:px-8 relative z-10">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/50 rounded-xl text-emerald-400 font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-[2rem] shadow-2xl">
                <div class="text-center mb-8">
                    <div class="w-14 h-14 bg-cyan-500/10 text-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-cyan-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white">Standar Validasi Sensor</h3>
                    <p class="text-slate-400 text-sm mt-2">Ubah batas ketinggian air (cm) yang memicu status Siaga dan Bahaya.</p>
                </div>

                <form action="{{ route('threshold.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="block text-amber-500 text-xs font-bold uppercase tracking-widest mb-2">Level Siaga</label>
                            <div class="relative">
                                <input type="number" name="batas_siaga" value="{{ $threshold->batas_siaga }}" required class="w-full bg-white border-2 border-slate-200 text-slate-950 font-black text-xl rounded-xl focus:ring-amber-500 focus:border-amber-500 p-3 pl-4 pr-12 shadow-inner text-center">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">CM</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-rose-500 text-xs font-bold uppercase tracking-widest mb-2">Level Bahaya</label>
                            <div class="relative">
                                <input type="number" name="batas_bahaya" value="{{ $threshold->batas_bahaya }}" required class="w-full bg-white border-2 border-slate-200 text-slate-950 font-black text-xl rounded-xl focus:ring-rose-500 focus:border-rose-500 p-3 pl-4 pr-12 shadow-inner text-center">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">CM</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-black py-3.5 rounded-xl transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] text-base tracking-wide">
                        SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>