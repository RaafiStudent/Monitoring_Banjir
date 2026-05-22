<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 md:border-b-0 md:border-r md:w-64 w-full shrink-0 flex flex-col justify-between relative z-30">
    
    <div class="flex flex-col w-full">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-cyan-500/10 text-cyan-400 rounded-xl flex items-center justify-center border border-cyan-500/20 font-black text-sm">
                    EWS
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-white text-xs tracking-widest uppercase leading-none">BPBD KOTA</span>
                    <span class="font-bold text-cyan-400 text-[10px] tracking-wider uppercase mt-1 leading-none">TEGAL</span>
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="text-slate-400 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div :class="open ? 'block' : 'hidden'" class="md:block p-4 space-y-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest pl-3 mb-3">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('dashboard')) bg-cyan-500 text-slate-950 @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Command Center
            </a>

            <a href="{{ route('contacts.index') }}" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('contacts.index')) bg-cyan-500 text-slate-950 @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Manajemen Kontak
            </a>

            <a href="{{ route('threshold.index') }}" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all @if(request()->routeIs('threshold.index')) bg-cyan-500 text-slate-950 @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                Ambang Batas
            </a>
        </div>
    </div>

    <div :class="open ? 'block' : 'hidden'" class="md:block p-4 border-t border-slate-800 bg-slate-900/50">
        @if(auth()->check())
            <div class="px-4 py-3 bg-slate-950 rounded-xl border border-slate-800 mb-3 overflow-hidden">
                <p class="font-bold text-white text-xs truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        @endif

        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-lg text-xs font-bold text-slate-400 hover:bg-slate-800 hover:text-white mb-1 transition-all">
            Pengaturan Profil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold text-rose-400 hover:bg-rose-500/10 transition-all">
                Keluar Aplikasi
            </button>
        </form>
    </div>

</nav>