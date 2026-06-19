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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
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
                                        <th class="py-4 px-4">Nama Pengguna</th>
                                        <th class="py-4 px-4">Nama Acara</th>
                                        <th class="py-4 px-4">Waktu Pendaftaran</th>
                                        <th class="py-4 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($recentRegistrations as $reg)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm">
                                                {{ $reg->user_name }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-sm font-medium">
                                                {{ $reg->event_title }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs font-semibold">
                                                📅 {{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xxs font-bold px-2.5 py-1 rounded-full shadow-sm">
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
