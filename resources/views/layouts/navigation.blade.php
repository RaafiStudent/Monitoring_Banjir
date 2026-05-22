<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 md:border-b-0 md:border-r md:w-[300px] w-full shrink-0 flex flex-col md:h-[100dvh] relative z-50">
    
    <div class="flex items-center justify-between px-6 md:px-8 py-4 md:py-6 border-b border-slate-800 shrink-0 w-full relative z-50 bg-slate-900">
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
            <button @click="open = ! open" class="text-slate-400 hover:text-white p-2 bg-slate-800/50 rounded-lg focus:outline-none transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" @click="open = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-xs"></div>

    <div :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" 
         class="fixed md:relative top-0 left-0 h-full md:h-[calc(100dvh-89px)] w-1/2 md:w-full bg-slate-900 border-r border-slate-800 md:border-none p-5 md:p-6 transition-transform duration-300 ease-in-out flex flex-col justify-between z-40 overflow-y-auto">
         
         <div class="space-y-2 md:space-y-3 w-full">
             <div class="flex items-center justify-between md:hidden pb-3 border-b border-slate-800 mb-4 pt-2">
                 <span class="font-black text-cyan-400 text-[10px] tracking-widest uppercase">Navigasi</span>
                 <button @click="open = false" class="text-slate-400 hover:text-white p-1">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                     </svg>
                 </button>
             </div>

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

             <form method="POST" action="{{ route('logout') }}" class="w-full block pt-2 border-t border-slate-800/60">
                 @csrf
                 <button type="submit" class="w-full flex items-center px-4 md:px-5 py-3 md:py-3.5 rounded-xl font-bold text-sm text-rose-400 hover:bg-rose-500/10 transition-all text-left">
                     Logout / Keluar
                 </button>
             </form>
         </div>

         @if(auth()->check())
             <div class="mt-auto pt-4 border-t border-slate-800 w-full block shrink-0">
                 <div class="px-4 py-3 bg-slate-950 rounded-xl border border-slate-800/80 overflow-hidden">
                     <p class="font-bold text-white text-xs truncate">{{ auth()->user()->name }}</p>
                     <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                 </div>
             </div>
         @endif
    </div>
</nav>