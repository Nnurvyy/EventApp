<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'EventApp') }} - Manajemen Pendaftaran Acara</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-gradient-to-tr from-emerald-50 via-slate-50 to-cyan-50 min-h-screen flex flex-col justify-between">
        
        <!-- Header / Navigation -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group focus:outline-none">
                <div class="transition-transform duration-300 group-hover:scale-110 ease-out">
                    <x-application-logo class="w-12 h-12 shadow-sm rounded-xl" />
                </div>
                <span class="text-xl font-bold text-slate-700 tracking-wide">
                    Event<span class="text-teal-600">App</span>
                </span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full shadow-sm transition transform hover:scale-105 active:scale-95 duration-150">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-teal-600 transition-colors">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full shadow-sm transition transform hover:scale-105 active:scale-95 duration-150">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Hero Section -->
        <main class="flex-grow flex items-center justify-center px-6 py-12">
            <div class="max-w-4xl w-full text-center flex flex-col items-center">
                <!-- Cute Mascot Welcome / Greeting -->
                <div class="mb-6 animate-bounce-subtle">
                    <div class="inline-flex items-center gap-2 bg-teal-100/50 border border-teal-200/50 px-4 py-2 rounded-full text-teal-800 text-sm font-bold shadow-sm">
                        <span>👋 Selamat datang di EventApp!</span>
                    </div>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 leading-tight tracking-tight">
                    Kelola & Ikuti Acara Seru <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-500">Bersama EventApp! 📅✨</span>
                </h1>
                
                <p class="mt-6 text-lg text-slate-500 max-w-2xl leading-relaxed">
                    Platform pendaftaran dan manajemen acara yang mudah, cepat, dan menggemaskan. Temukan aktivitas favoritmu, lakukan pendaftaran dalam sekali klik, dan dapatkan konfirmasi instan!
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full shadow-md hover:shadow-lg transition transform hover:scale-105 active:scale-98 duration-150 cursor-pointer">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full shadow-md hover:shadow-lg transition transform hover:scale-105 active:scale-98 duration-150 cursor-pointer">
                            Mulai Sekarang (Gratis)
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-full shadow-sm hover:bg-slate-50 active:bg-slate-100 transition duration-150 cursor-pointer">
                            Sudah punya akun? Login
                        </a>
                    @endauth
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-8 border-t border-slate-200/50 mt-12 bg-white/40 backdrop-blur-sm">
            <p class="text-sm text-slate-400 font-medium">
                &copy; {{ date('Y') }} EventApp. Dibuat dengan 💚 untuk para pencinta acara.
            </p>
        </footer>

        <!-- Custom Micro-animations CSS -->
        <style>
            @keyframes bounce-subtle {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-4px);
                }
            }
            .animate-bounce-subtle {
                animation: bounce-subtle 2s ease-in-out infinite;
            }
        </style>
    </body>
</html>
