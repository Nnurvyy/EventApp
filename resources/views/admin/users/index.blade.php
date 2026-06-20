<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Kelola User 👤') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Daftar pengguna terdaftar di platform Anda.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transform hover:scale-102 active:scale-98 transition duration-150 cursor-pointer">
                ➕ Tambah User Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, deleteActionUrl: '', userName: '', userEmail: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Session Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-2 border-slate-800 text-emerald-800 text-sm font-semibold rounded-2xl shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] flex items-center gap-2">
                    <span>✨</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-rose-50 border-2 border-slate-800 text-rose-800 text-sm font-semibold rounded-2xl shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white/90 border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    
                    <!-- Search Controls -->
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 flex items-center gap-3">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('direction'))
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        @endif

                        <div class="relative w-full max-w-3xl">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau role..." class="w-full text-xs font-semibold px-4 py-2.5 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white">
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                            Cari 🔍
                        </button>
                        @if(request()->filled('search'))
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer h-[40px]">
                                Reset 🔄
                            </a>
                        @endif
                    </form>

                    @if ($users->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">👥</div>
                            <h4 class="text-lg font-bold text-slate-700">Tidak Ada User Ditemukan</h4>
                            <p class="text-slate-500 text-sm mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-slate-800 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => (request('sort') === 'name' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Nama
                                                @if(request('sort') === 'name')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => (request('sort') === 'email' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Email
                                                @if(request('sort') === 'email')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'role', 'direction' => (request('sort') === 'role' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Role
                                                @if(request('sort') === 'role')
                                                    <span class="text-xs">{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => (request('sort') === 'created_at' && request('direction') === 'asc') ? 'desc' : 'asc', 'page' => 1]) }}" class="hover:text-teal-600 inline-flex items-center gap-1 font-bold">
                                                Tanggal Registrasi
                                                @if(request('sort') === 'created_at' || !request('sort'))
                                                    <span class="text-xs">{{ request('direction', 'desc') === 'asc' ? '▲' : '▼' }}</span>
                                                @else
                                                    <span class="text-slate-300 text-xs">↕</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="py-4 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="ml-1.5 inline-flex items-center bg-blue-100 text-blue-800 border border-blue-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                        Anda
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-xs">
                                                {{ $user->email }}
                                            </td>
                                            <td class="py-4 px-4">
                                                @if($user->role === 'admin')
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-rose-100 text-rose-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">
                                                        Admin 👑
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center gap-1.5 bg-teal-100 text-teal-800 border-2 border-slate-800 text-xxs font-bold px-2.5 py-1 rounded-full shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] whitespace-nowrap">
                                                        User Biasa 👤
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs font-semibold">
                                                📅 {{ $user->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 active:bg-amber-200 rounded-xl transition duration-150 border border-amber-200" title="Edit User">
                                                        ✏️
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <button type="button" @click="deleteActionUrl = '{{ route('admin.users.destroy', $user) }}'; userName = '{{ addslashes($user->name) }}'; userEmail = '{{ addslashes($user->email) }}'; showDeleteModal = true;" class="inline-flex items-center justify-center p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 active:bg-rose-200 rounded-xl transition duration-150 cursor-pointer border border-rose-200" title="Hapus User">
                                                            🗑️
                                                        </button>
                                                    @else
                                                        <span class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-400 rounded-xl border border-slate-200 cursor-not-allowed" title="Tidak Bisa Hapus Diri Sendiri">
                                                            🔒
                                                        </span>
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
                            {{ $users->links('components.pagination') }}
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
                <h3 class="text-xl font-black text-slate-800 mb-2">Hapus User Ini?</h3>
                <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                    Apakah Anda yakin ingin menghapus user <span class="font-bold text-slate-800" x-text="userName"></span> (<span class="text-xs text-slate-500" x-text="userEmail"></span>)? Tindakan ini akan menghapus semua riwayat pendaftaran acara pengguna ini secara permanen.
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
                const shouldFocus = sessionStorage.getItem('search_focus_users') === 'true';
                if (shouldFocus) {
                    sessionStorage.removeItem('search_focus_users');
                    searchInput.focus();
                    const val = searchInput.value;
                    searchInput.value = '';
                    searchInput.value = val;
                }

                let timeout = null;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        sessionStorage.setItem('search_focus_users', 'true');
                        searchInput.closest('form').submit();
                    }, 500); // 500ms debounce
                });
            }
        });
    </script>
</x-app-layout>
