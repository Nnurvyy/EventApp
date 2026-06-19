<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-md overflow-hidden border border-slate-100 shadow-sm rounded-3xl">
                <div class="p-8">
                    <!-- Fresh Pastel Alert Card -->
                    <div class="flex items-center gap-4 bg-teal-50 border border-teal-100 p-6 rounded-2xl text-teal-800 shadow-sm animate-pulse-subtle">
                        <div class="p-3 bg-teal-100 text-teal-600 rounded-xl">
                            <!-- Cute crown or key icon -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold font-sans">Halo Admin!</h3>
                            <p class="mt-1 text-teal-600 font-medium">Selamat datang Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
