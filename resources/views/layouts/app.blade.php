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
    <body class="font-sans antialiased text-slate-300 bg-slate-950 overflow-hidden">
        
        <div class="h-[100dvh] flex flex-col md:flex-row bg-slate-950 w-full">
            
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-slate-950 relative">
                
                <div class="sticky top-0 z-40 bg-slate-900/90 backdrop-blur-md border-b border-slate-800 h-[60px] md:h-[89px] shrink-0 flex items-center justify-end px-6 sm:px-8">
                    </div>

                @isset($header)
                    <header class="bg-slate-900 border-b border-slate-800 shadow shrink-0 relative z-20">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:py-6 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 relative pb-12">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>