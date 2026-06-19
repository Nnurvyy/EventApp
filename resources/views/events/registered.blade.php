<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali ke Dashboard">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Acara yang Saya Ikuti') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    @if ($registeredEvents->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">🎈</div>
                            <h4 class="text-lg font-bold text-slate-700">Belum Mengikuti Acara</h4>
                            <p class="text-slate-500 text-sm mt-1">Anda belum mendaftar ke acara apa pun saat ini.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full shadow-md hover:shadow-lg transition duration-150 cursor-pointer mt-5 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                                Temukan Acara Seru ✨
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-slate-800 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4">Nama Acara</th>
                                        <th class="py-4 px-4">Harga</th>
                                        <th class="py-4 px-4">Tanggal Pelaksanaan</th>
                                        <th class="py-4 px-4">Tanggal Pendaftaran</th>
                                        <th class="py-4 px-4">Status</th>
                                        <th class="py-4 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($registeredEvents as $reg)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm max-w-xs">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-12 h-12 rounded-xl overflow-hidden border-2 border-slate-800 flex-shrink-0 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-slate-100">
                                                        @if ($reg->event_picture)
                                                            <img src="{{ asset('storage/' . $reg->event_picture) }}" class="w-full h-full object-cover" alt="{{ $reg->title }}">
                                                        @else
                                                            <x-event-placeholder class="w-full h-full" />
                                                        @endif
                                                    </div>
                                                    <span class="truncate">{{ $reg->title }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-xs font-bold text-slate-700">
                                                @if ($reg->price == 0)
                                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full shadow-sm">
                                                        Gratis
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full shadow-sm">
                                                        Rp {{ number_format($reg->price, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-xs font-semibold">
                                                📅 {{ \Carbon\Carbon::parse($reg->event_date)->format('d M Y') }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs">
                                                {{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xxs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                                    {{ $reg->status === 'registered' ? 'Terdaftar' : 'Dikonfirmasi' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <a href="{{ route('events.show', $reg->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 font-bold text-xs rounded-xl transition duration-150 border border-slate-300">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $registeredEvents->links('components.pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
