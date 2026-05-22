<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 md:border-b-0 md:border-r md:w-64 w-full shrink-0 flex flex-col justify-between transition-all duration-300 relative z-30">
    
    <div class="flex flex-col w-full">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-cyan-500/10 text-cyan-400 rounded-xl flex items-center justify-center border border-cyan-500/20 font-black text-sm shadow-[0_0_15px_rgba(34,211,238,0.1)]">
                    EWS
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-white text-xs tracking-widest uppercase leading-none">BPBD KOTA</span>
                    <span class="font-bold text-cyan-400 text-[10px] tracking-wider uppercase mt-1 leading-none">TEGAL</span>
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden md:block p-4 space-y-1.5">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] pl-3 mb-3">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-sm transition-all group {{ request()->routeIs('dashboard') ? 'bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)]' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('dashboard') ? 'text-slate-950' : 'text-slate-400 group-hover:text-cyan-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
                Command Center
            </a>

            <a href="{{ route('contacts.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-sm transition-all group {{ request()->routeIs('contacts.index') ? 'bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)]' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('contacts.index') ? 'text-slate-950' : 'text-slate-400 group-hover:text-cyan-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Manajemen Kontak
            </a>

            <a href="{{ route('threshold.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-bold text-sm transition-all group {{ request()->routeIs('threshold.index') ? 'bg-cyan-500 text-slate-950 shadow-[0_0_15px_rgba(6,182,212,0.35)]' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('threshold.index') ? 'text-slate-950' : 'text-slate-400 group-hover:text-cyan-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Ambang Batas
            </a>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:block p-4 border-t border-slate-800/60 bg-slate-900/50">
        <div class="px-4 py-3 bg-slate-950 rounded-xl border border-slate-800/80 mb-3 flex flex-col overflow-hidden">
            <span class="font-bold text-white text-xs truncate">{{ Auth::user()->name }}</span>
            <span class="text-[10px] text-slate-500 mt-1 truncate">{{ Auth::user()->email }}</span>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-bold text-slate-400 hover:bg-slate-800/60 hover:text-white transition-all mb-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            Pengaturan Profil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-bold text-rose-400 hover:bg-rose-500/10 transition-all text-left">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Keluar Aplikasi
            </button>
        </form>
    </div>

</nav>