<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Halo Admin, {{ Auth::user()->name }}! 🌟
                </h2>
                <p class="text-slate-500 text-sm mt-1">Semua kontrol manajemen acara berada di bawah pantauan Anda.</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full shadow-md hover:shadow-lg hover:scale-102 active:scale-98 transform transition duration-150 cursor-pointer border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                ⚙️ Kelola Acara
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Stats Grid (Cute Neo-brutalist Style) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Item: Total Events -->
                <div class="bg-emerald-100 border-2 border-slate-800 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rounded-2xl p-6 flex flex-col justify-between h-36">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Total Acara</span>
                        <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-white flex items-center justify-center shadow-sm text-lg">
                            📅
                        </div>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalEvents }}</span>
                    </div>
                </div>

                <!-- Stat Item: Total Users -->
                <div class="bg-amber-100 border-2 border-slate-800 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rounded-2xl p-6 flex flex-col justify-between h-36">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">User Terdaftar</span>
                        <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-white flex items-center justify-center shadow-sm text-lg">
                            👥
                        </div>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalUsers }}</span>
                    </div>
                </div>

                <!-- Stat Item: Total Registrations -->
                <div class="bg-cyan-100 border-2 border-slate-800 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rounded-2xl p-6 flex flex-col justify-between h-36">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Total Pendaftar</span>
                        <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-white flex items-center justify-center shadow-sm text-lg">
                            ⚡
                        </div>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalRegistrations }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations Feed Table (Cute Neo-brutalist Style) -->
            <div class="bg-white/90 border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span>🔔</span> Pendaftaran Acara Terbaru
                    </h3>

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
                                    <tr class="border-b-2 border-slate-800 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4 font-bold">Nama Acara</th>
                                        <th class="py-4 px-4 font-bold">Nama Pengguna</th>
                                        <th class="py-4 px-4 font-bold">Waktu Pendaftaran</th>
                                        <th class="py-4 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($recentRegistrations as $reg)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 text-slate-800 text-sm font-bold max-w-xs">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-12 h-12 rounded-xl overflow-hidden border-2 border-slate-800 flex-shrink-0 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-slate-100">
                                                        @if ($reg->event_picture)
                                                            <img src="{{ asset('storage/' . $reg->event_picture) }}" class="w-full h-full object-cover" alt="{{ $reg->event_title }}">
                                                        @else
                                                            <x-event-placeholder class="w-full h-full" />
                                                        @endif
                                                    </div>
                                                    <span class="truncate">{{ $reg->event_title }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm">
                                                {{ $reg->user_name }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs font-semibold">
                                                📅 {{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4">
                                                @if ($reg->status === 'registered')
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">Terdaftar</span>
                                                @elseif ($reg->status === 'confirmed')
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-teal-100 text-teal-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">Dikonfirmasi ✓</span>
                                                @elseif ($reg->status === 'pending')
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-amber-100 text-amber-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">Pending ⏳</span>
                                                @elseif ($reg->status === 'cancelled')
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-rose-100 text-rose-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">Dibatalkan ❌</span>
                                                @else
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-slate-100 text-slate-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">{{ $reg->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- View All Link -->
                        <div class="mt-6 border-t-2 border-slate-800 pt-6 flex justify-end">
                            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 font-bold text-xs text-slate-700 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transform hover:scale-102 active:scale-98 cursor-pointer">
                                Lihat Semua Pendaftaran ➡️
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
