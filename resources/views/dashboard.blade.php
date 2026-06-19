<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Alert Card -->
            <div class="bg-white/80 backdrop-blur-md overflow-hidden border border-slate-100 shadow-sm rounded-3xl p-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 bg-emerald-100 text-emerald-600 rounded-2xl">
                        <!-- Cute smiling face icon -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Halo, {{ Auth::user()->name }}! ✨</h3>
                        <p class="text-slate-500 text-xs mt-0.5">Selamat datang di dashboard personal Anda.</p>
                    </div>
                </div>
                <a href="{{ route('events.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full shadow-sm hover:shadow-md transition duration-150 cursor-pointer">
                    🔍 Jelajahi Acara
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Item: Registered Events -->
                <div class="bg-gradient-to-tr from-emerald-100/30 to-emerald-50 border border-emerald-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-100 text-emerald-600 rounded-2xl text-2xl shadow-sm">
                        📅
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Acara yang Diikuti</span>
                        <span class="text-3xl font-extrabold text-slate-800">{{ $registeredCount }}</span>
                    </div>
                </div>

                <!-- Stat Item: Account Type -->
                <div class="bg-gradient-to-tr from-cyan-100/30 to-cyan-50 border border-cyan-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-cyan-100 text-cyan-600 rounded-2xl text-2xl shadow-sm">
                        👤
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Tipe Akun</span>
                        <span class="text-lg font-bold text-slate-800 capitalize">{{ Auth::user()->role === 'user' ? 'User Biasa' : 'Admin' }}</span>
                    </div>
                </div>

                <!-- Stat Item: Active Event Dates -->
                <div class="bg-gradient-to-tr from-teal-100/30 to-teal-50 border border-teal-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-teal-100 text-teal-600 rounded-2xl text-2xl shadow-sm">
                        ✨
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Status Pendaftaran</span>
                        <span class="text-lg font-bold text-slate-800">Aktif & Terverifikasi</span>
                    </div>
                </div>
            </div>

            <!-- Followed Events Table Section -->
            <div class="bg-white/80 backdrop-blur-md border border-slate-100 shadow-xl shadow-slate-100/50 rounded-3xl">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">📅 Acara yang Saya Ikuti</h3>

                    @if ($registeredEvents->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-4xl mb-3">🎈</div>
                            <h4 class="text-base font-bold text-slate-700">Belum Mengikuti Acara</h4>
                            <p class="text-slate-500 text-xs mt-1">Anda belum mendaftar ke acara apa pun saat ini.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full shadow-sm hover:shadow-md transition duration-150 cursor-pointer mt-4">
                                Temukan Acara Seru
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4">Nama Acara</th>
                                        <th class="py-4 px-4">Tanggal Pelaksanaan</th>
                                        <th class="py-4 px-4">Tanggal Pendaftaran</th>
                                        <th class="py-4 px-4">Status</th>
                                        <th class="py-4 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach ($registeredEvents as $reg)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm truncate max-w-xs">
                                                {{ $reg->title }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-xs font-semibold">
                                                📅 {{ \Carbon\Carbon::parse($reg->event_date)->format('d M Y') }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs">
                                                {{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xxs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                                    {{ $reg->status === 'registered' ? 'Terdaftar' : 'Dikonfirmasi' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <a href="{{ route('events.show', $reg->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 font-bold text-xs rounded-xl transition duration-150">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
