<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard Admin 👑') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Alert Card -->
            <div class="bg-white/80 backdrop-blur-md overflow-hidden border border-slate-100 shadow-sm rounded-3xl p-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 bg-teal-100 text-teal-600 rounded-2xl">
                        <!-- Key or crown icon -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Halo Admin, {{ Auth::user()->name }}! 🌟</h3>
                        <p class="text-slate-500 text-xs mt-0.5">Semua kontrol manajemen acara berada di bawah pantauan Anda.</p>
                    </div>
                </div>
                <a href="{{ route('admin.events.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full shadow-sm hover:shadow-md transition duration-150 cursor-pointer">
                    ⚙️ Kelola Acara
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Item: Total Events -->
                <div class="bg-gradient-to-tr from-emerald-100/30 to-emerald-50 border border-emerald-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-100 text-emerald-600 rounded-2xl text-2xl shadow-sm">
                        📅
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Total Acara</span>
                        <span class="text-3xl font-extrabold text-slate-800">{{ $totalEvents }}</span>
                    </div>
                </div>

                <!-- Stat Item: Total Users -->
                <div class="bg-gradient-to-tr from-cyan-100/30 to-cyan-50 border border-cyan-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-cyan-100 text-cyan-600 rounded-2xl text-2xl shadow-sm">
                        👥
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">User Terdaftar</span>
                        <span class="text-3xl font-extrabold text-slate-800">{{ $totalUsers }}</span>
                    </div>
                </div>

                <!-- Stat Item: Total Registrations -->
                <div class="bg-gradient-to-tr from-teal-100/30 to-teal-50 border border-teal-100/60 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-teal-100 text-teal-600 rounded-2xl text-2xl shadow-sm">
                        ⚡
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Total Pendaftar</span>
                        <span class="text-3xl font-extrabold text-slate-800">{{ $totalRegistrations }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations Feed Table -->
            <div class="bg-white/80 backdrop-blur-md border border-slate-100 shadow-xl shadow-slate-100/50 rounded-3xl">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">🔔 Pendaftaran Acara Terbaru</h3>

                    @if ($recentRegistrations->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-4xl mb-3">📋</div>
                            <h4 class="text-base font-bold text-slate-700">Belum Ada Pendaftaran</h4>
                            <p class="text-slate-500 text-xs mt-1">Data pendaftaran dari para pengguna akan langsung tampil di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4">Nama Pengguna</th>
                                        <th class="py-4 px-4">Nama Acara</th>
                                        <th class="py-4 px-4">Waktu Pendaftaran</th>
                                        <th class="py-4 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach ($recentRegistrations as $reg)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm">
                                                {{ $reg->user_name }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-sm">
                                                {{ $reg->event_title }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs">
                                                {{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xxs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                                    {{ $reg->status === 'registered' ? 'Terdaftar' : 'Dikonfirmasi' }}
                                                </span>
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
