<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Kelola Acara (CRUD)') }}
            </h2>
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:scale-102 active:scale-98 transform transition duration-150 cursor-pointer">
                ➕ Tambah Acara Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-2 border-slate-800 text-emerald-800 text-sm font-semibold rounded-2xl shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] flex items-center gap-2">
                    <span>✨</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    @if ($events->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">📅</div>
                            <h3 class="text-lg font-bold text-slate-700">Belum Ada Acara</h3>
                            <p class="text-slate-500 text-sm mt-1">Klik tombol di atas untuk menambahkan acara baru pertama Anda.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-slate-800 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                        <th class="py-4 px-4 w-20">Foto</th>
                                        <th class="py-4 px-4">Judul Acara</th>
                                        <th class="py-4 px-4">Deskripsi</th>
                                        <th class="py-4 px-4">Tanggal Pelaksanaan</th>
                                        <th class="py-4 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($events as $event)
                                        <tr class="hover:bg-slate-50/50 transition duration-150">
                                            <td class="py-4 px-4">
                                                @if ($event->event_picture)
                                                    <img src="{{ asset('storage/' . $event->event_picture) }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm" alt="{{ $event->title }}">
                                                @else
                                                    <x-event-placeholder class="w-12 h-12 rounded-xl border border-slate-200 shadow-sm" />
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 font-bold text-slate-800 text-sm sm:max-w-xs truncate">
                                                {{ $event->title }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-500 text-xs sm:max-w-sm truncate">
                                                {{ Str::limit($event->description, 100) }}
                                            </td>
                                            <td class="py-4 px-4 text-slate-600 text-xs font-semibold">
                                                <span class="inline-flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                                                    📅 {{ $event->event_date->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- View -->
                                                    <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border border-slate-300" title="Detail">
                                                        👁️
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center justify-center p-2 bg-cyan-50 text-cyan-600 hover:bg-cyan-100 active:bg-cyan-200 rounded-xl transition duration-150 border border-cyan-200" title="Edit">
                                                        ✏️
                                                    </a>
                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center justify-center p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 active:bg-rose-200 rounded-xl transition duration-150 cursor-pointer border border-rose-200" title="Hapus">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $events->links('components.pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
