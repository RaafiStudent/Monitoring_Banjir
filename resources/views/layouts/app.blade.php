<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Command Center - BPBD</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <style> body { font-family: 'Poppins', sans-serif; } </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased text-slate-300 bg-slate-950">
        
        <div class="min-h-screen flex flex-col md:flex-row bg-slate-950">
            
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                <div class="bg-slate-900 border-b border-slate-800 h-[89px] flex items-center justify-end px-6 sm:px-8 relative z-20">
                    <div class="flex items-center gap-6">
                        @if(auth()->check())
                            <div class="text-right hidden sm:block">
                                <p class="font-bold text-white text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                        @endif
                        
                        <div class="w-px h-8 bg-slate-800 hidden sm:block"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-rose-500/10 border border-rose-500/20 rounded-xl text-xs font-bold text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-[0_0_15px_rgba(244,63,94,0.1)] uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @isset($header)
                    <header class="bg-slate-900 border-b border-slate-800 shadow relative z-20">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 overflow-y-auto relative">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>