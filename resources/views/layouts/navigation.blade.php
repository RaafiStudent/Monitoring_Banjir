<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 md:border-b-0 md:border-r md:w-[300px] w-full shrink-0 flex flex-col md:h-[100dvh] relative z-50">
    
    <div class="flex flex-col w-full">
        <div class="flex items-center justify-between px-6 md:px-8 py-4 md:py-6 border-b border-slate-800 shrink-0">
            <div class="flex items-center gap-3 md:gap-4">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-cyan-500/10 text-cyan-400 rounded-xl flex items-center justify-center border border-cyan-500/20 font-black text-sm md:text-base shadow-[0_0_15px_rgba(34,211,238,0.1)]">
                    EWS
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-white text-xs md:text-sm tracking-widest uppercase leading-none">BPBD KOTA</span>
                    <span class="font-bold text-cyan-400 text-[9px] md:text-[11px] tracking-wider uppercase mt-1 md:mt-1.5 leading-none">TEGAL</span>
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="text-slate-400 hover:text-white p-2 bg-slate-800/50 rounded-lg focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div :class="open ? 'block' : 'hidden'" class="md:block p-4 md:p-6 space-y-2 md:space-y-3 overflow-y-auto max-h-[60vh] md:max-h-full">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest pl-2 mb-3 md:mb-4">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="flex items-center px-4 md:px-5 py-3 md:py-3.5 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('dashboard')) bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)] @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Command Center
            </a>

            <a href="{{ route('contacts.index') }}" class="flex items-center px-4 md:px-5 py-3 md:py-3.5 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('contacts.index')) bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)] @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Manajemen Kontak
            </a>

            <a href="{{ route('threshold.index') }}" class="flex items-center px-4 md:px-5 py-3 md:py-3.5 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('threshold.index')) bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)] @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Ambang Batas
            </a>
        </div>
    </div>
</nav>