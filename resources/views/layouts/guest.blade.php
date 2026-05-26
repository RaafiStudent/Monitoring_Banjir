<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <style> body { font-family: 'Poppins', sans-serif; } </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-300 relative overflow-hidden min-h-screen">
        
        <div class="absolute top-[-10%] left-[-10%] w-[30rem] h-[30rem] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 px-4">
            
            <div class="w-full sm:max-w-md flex flex-col items-center">
                {{ $logo }}
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-slate-900/60 backdrop-blur-xl border border-slate-800/80 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden rounded-[2rem]">
                {{ $slot }}
            </div>

            <div class="text-center mt-8 text-[10px] font-medium text-slate-500 uppercase tracking-widest">
                &copy; 2026 BPBD KOTA TEGAL
            </div>
            
        </div>
    </body>
</html>