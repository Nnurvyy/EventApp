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
                    <!-- Search Controls -->
                    <form method="GET" action="{{ route('events.registered') }}" class="mb-6 flex items-center gap-3">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('direction'))
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        @endif

                        <div class="relative w-full max-w-3xl">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama acara atau status..." class="w-full text-xs font-semibold px-4 py-2.5 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white">
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                            Cari 🔍
                        </button>
                        @if(request()->filled('search'))
                            <a href="{{ route('events.registered') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                                Reset 🔄
                            </a>
                        @endif
                    </form>

                    @if ($registeredEvents->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">🎈</div>
                            <h4 class="text-lg font-bold text-slate-700">Belum Mengikuti Acara</h4>
                            <p class="text-slate-500 text-sm mt-1">
                                @if(request()->filled('search'))
                                    Tidak ada acara yang cocok dengan kata kunci pencarian Anda.
                                @else
                                    Anda belum mendaftar ke acara apa pun saat ini.
                                @endif
                            </p>
                            @if(request()->filled('search'))
                                <a href="{{ route('events.registered') }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 font-bold text-xs text-slate-700 rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer mt-5">
                                    Bersihkan Pencarian 🔄
                                </a>
                            @else
                                <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer mt-5">
                                    Temukan Acara Seru ✨
                                </a>
                            @endif
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
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => (request('sort') === 'price' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Harga
                                                @if(request('sort') === 'price')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'event_date', 'direction' => (request('sort') === 'event_date' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Tanggal Pelaksanaan
                                                @if(request('sort') === 'event_date')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'registered_at', 'direction' => (request('sort') === 'registered_at' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Tanggal Pendaftaran
                                                @if(request('sort') === 'registered_at' || !request('sort'))
                                                    <span class="text-xs">{{ request('direction', 'desc') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => (request('sort') === 'status' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
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
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('events.show', $reg->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 font-bold text-xs rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer">
                                                        Lihat Detail
                                                    </a>
                                                    @if ($reg->status === 'pending' && !empty($reg->snap_token))
                                                        <button type="button" onclick="payPendingRegistration('{{ $reg->snap_token }}')" class="inline-flex items-center justify-center px-4 py-2 bg-amber-400 hover:bg-amber-500 active:bg-amber-600 text-slate-800 font-bold text-xs rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer">
                                                            Bayar 💳
                                                        </button>
                                                    @endif
                                                </div>
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

    <!-- Midtrans Snap Script & Callback Trigger -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        function payPendingRegistration(token) {
            if (!token) {
                alert('Token pembayaran tidak valid.');
                return;
            }
            window.snap.pay(token, {
                onSuccess: function(result){
                    alert("Pembayaran berhasil! 🎉");
                    window.location.reload();
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda. 💳");
                    window.location.reload();
                },
                onError: function(result){
                    alert("Pembayaran gagal! ❌");
                    window.location.reload();
                },
                onClose: function(){
                    alert("Anda menutup halaman pembayaran sebelum menyelesaikannya. 😅");
                }
            });
        }

        // Automatic live search with focus retention
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                const shouldFocus = sessionStorage.getItem('search_focus_user_registered') === 'true';
                if (shouldFocus) {
                    sessionStorage.removeItem('search_focus_user_registered');
                    searchInput.focus();
                    const val = searchInput.value;
                    searchInput.value = '';
                    searchInput.value = val;
                }

                let timeout = null;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        sessionStorage.setItem('search_focus_user_registered', 'true');
                        searchInput.closest('form').submit();
                    }, 500); // 500ms debounce
                });
            }
        });
    </script>
</x-app-layout>
