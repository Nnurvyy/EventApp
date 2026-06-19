<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-md overflow-hidden border border-slate-100 shadow-sm rounded-3xl">
                <div class="p-8">
                    <!-- Fresh Pastel Alert Card -->
                    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-100 p-6 rounded-2xl text-emerald-800 shadow-sm">
                        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                            <!-- Cute user or happy face icon -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold font-sans">Halo User!</h3>
                            <p class="mt-1 text-emerald-600 font-medium">Selamat datang User</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
