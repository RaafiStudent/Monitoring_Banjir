<x-guest-layout>
    
    <x-slot name="logo">
        <a href="/">
            <img src="{{ asset('logo.png') }}" alt="Logo Universitas" 
                 class="w-24 h-24 rounded-full object-cover border-2 border-cyan-500/50 shadow-[0_0_15px_rgba(34,211,238,0.4)] mx-auto transition-transform hover:scale-105">
        </a>
        <h2 class="text-center text-xl font-black text-white tracking-wide uppercase mt-4">
            COMMAND CENTER
        </h2>
        <p class="text-center text-xs font-bold text-cyan-400 tracking-widest uppercase mt-1" style="text-shadow: 0 0 15px rgba(34, 211, 238, 0.4);">
            EWS BANJIR KALIGANGSA
        </p>
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 pl-1">Alamat Email</label>
            <div class="relative">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email admin..." 
                       class="w-full bg-slate-950/80 border border-slate-800/80 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 pl-1">Kata Sandi</label>
            <div class="relative">
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan password..." 
                       class="w-full bg-slate-950/80 border border-slate-800/80 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-slate-800 bg-slate-950 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-900 w-4 h-4 transition-colors" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-400 hover:text-slate-300 transition-colors">Ingat akun saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-slate-500 hover:text-cyan-400 transition-colors">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-black text-sm uppercase tracking-widest py-4 rounded-xl transition-all duration-300 shadow-[0_4px_20px_rgba(6,182,212,0.3)] hover:shadow-[0_4px_25px_rgba(6,182,212,0.5)] active:scale-[0.99]">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</x-guest-layout>