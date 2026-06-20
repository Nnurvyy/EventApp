<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EventApp') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-gradient-to-tr from-emerald-50 via-slate-50 to-cyan-50 min-h-screen flex items-center justify-center py-10 px-4">
        <div class="w-full sm:max-w-md flex flex-col items-center">
            <div class="mb-6 text-center group">
                <a href="/" class="flex flex-col items-center gap-2 focus:outline-none">
                    <div class="transition-transform duration-300 group-hover:scale-110 ease-out">
                        <x-application-logo class="w-20 h-20 shadow-md rounded-3xl" />
                    </div>
                    <span class="mt-2 text-2xl font-bold text-slate-700 tracking-wide font-sans">
                        Event<span class="text-teal-600">App</span>
                    </span>
                </a>
            </div>

            <div class="w-full bg-white/90 backdrop-blur-md border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden rounded-3xl p-8 sm:p-10 transition-all duration-300 hover:shadow-2xl hover:shadow-slate-200/70">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
