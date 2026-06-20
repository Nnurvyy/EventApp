<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali ke Dashboard">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Semua Pendaftaran Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, deleteActionUrl: '', userName: '', eventTitle: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/90 border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    <!-- Search Controls -->
                    <form method="GET" action="{{ route('admin.registrations.index') }}" class="mb-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('direction'))
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        @endif

                        <div class="relative w-full max-w-3xl">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama user atau nama acara..." class="w-full text-xs font-semibold px-4 py-2.5 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white">
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                            Cari 🔍
                        </button>
                        @if(request()->filled('search'))
                            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                                Reset 🔄
                            </a>
                        @endif
                    </form>

                    <!-- Grand Total Pemasukan Card -->
                    <div class="mb-6 bg-emerald-100 border-2 border-slate-800 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl border-2 border-slate-800 bg-white flex items-center justify-center shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] text-lg">
                                💰
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Grand Total Pemasukan</h4>
                                <p class="text-slate-500 text-[10px] font-semibold mt-0.5">* Total pendapatan dari pendaftaran yang aktif (Terdaftar & Dikonfirmasi)</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if ($recentRegistrations->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">📋</div>
                            <h4 class="text-lg font-bold text-slate-700">Belum Ada Pendaftaran</h4>
                            <p class="text-slate-500 text-sm mt-1">Data pendaftaran dari para pengguna akan langsung tampil di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-slate-800 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'event_title', 'direction' => (request('sort') === 'event_title' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Nama Acara
                                                @if(request('sort') === 'event_title')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'user_name', 'direction' => (request('sort') === 'user_name' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Nama Pengguna
                                                @if(request('sort') === 'user_name')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'event_price', 'direction' => (request('sort') === 'event_price' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1">
                                                Harga
                                                @if(request('sort') === 'event_price')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'registered_at', 'direction' => (request('sort') === 'registered_at' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1">
                                                Waktu Pendaftaran
                                                @if(request('sort') === 'registered_at' || !request('sort'))
                                                    <span class="text-xs">{{ request('direction', 'desc') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => (request('sort') === 'status' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1">
                                                Status
                                                @if(request('sort') === 'status')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4 text-center">Aksi</th>
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
                                            <td class="py-4 px-4 text-xs font-bold text-slate-700">
                                                @if ($reg->event_price == 0)
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-800 border-2 border-slate-800 px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">
                                                        Gratis
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-amber-100 text-amber-800 border-2 border-slate-800 px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">
                                                        Rp {{ number_format($reg->event_price, 0, ',', '.') }}
                                                    </span>
                                                @endif
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
                                            <td class="py-4 px-4 text-center">
                                                <button type="button" @click="deleteActionUrl = '{{ route('admin.registrations.destroy', $reg->registration_id) }}'; userName = '{{ addslashes($reg->user_name) }}'; eventTitle = '{{ addslashes($reg->event_title) }}'; showDeleteModal = true;" class="inline-flex items-center justify-center p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 active:bg-rose-200 rounded-xl transition duration-150 cursor-pointer border border-rose-200" title="Hapus Pendaftaran">
                                                    🗑️
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $recentRegistrations->links('components.pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Cute Deletion Confirmation Modal -->
        <div x-show="showDeleteModal" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak>
            <div @click.away="showDeleteModal = false" class="bg-white border-4 border-slate-800 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] rounded-3xl p-6 text-center relative mx-auto" style="max-width: 380px; width: 100%; box-sizing: border-box;">
                <div class="bg-rose-100 border-2 border-slate-800 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" style="width: 64px; height: 64px; min-width: 64px; min-height: 64px;">
                    🗑️
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Batalkan Pendaftaran?</h3>
                <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                    Apakah Anda yakin ingin menghapus pendaftaran <span class="font-bold text-slate-800" x-text="userName"></span> untuk acara <span class="font-bold text-slate-800" x-text="'&ldquo;' + eventTitle + '&rdquo;'"></span>?
                </p>
                <form :action="deleteActionUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 border-2 border-slate-800 rounded-xl font-bold text-xs text-slate-700 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer transition active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-rose-500 hover:bg-rose-600 text-white border-2 border-slate-800 rounded-xl font-bold text-xs shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer transition active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]" style="background-color: #f43f5e !important; color: #ffffff !important;">
                            Ya, Hapus! 💥
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for automatic live search with focus retention -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                // Restore focus and position cursor to end
                const shouldFocus = sessionStorage.getItem('search_focus_registrations') === 'true';
                if (shouldFocus) {
                    sessionStorage.removeItem('search_focus_registrations');
                    searchInput.focus();
                    const val = searchInput.value;
                    searchInput.value = '';
                    searchInput.value = val;
                }

                let timeout = null;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        sessionStorage.setItem('search_focus_registrations', 'true');
                        searchInput.closest('form').submit();
                    }, 500); // 500ms debounce
                });
            }
        });
    </script>
</x-app-layout>
