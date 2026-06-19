<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl p-6 md:p-8">
                <!-- Event Image Header -->
                <div class="mb-6 relative h-64 md:h-80 overflow-hidden rounded-3xl border-2 border-slate-800">
                    @if ($event->event_picture)
                        <img src="{{ asset('storage/' . $event->event_picture) }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
                    @else
                        <x-event-placeholder class="w-full h-full" />
                    @endif
                </div>

                <!-- Event Header Details -->
                <div class="mb-6 pb-6 border-b-2 border-slate-800">
                    <span class="inline-flex items-center gap-1.5 bg-teal-100 text-teal-800 border-2 border-slate-800 text-xs font-bold px-3 py-1.5 rounded-full mb-3 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                        📅 {{ $event->event_date->format('d M Y') }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-800 leading-tight">{{ $event->title }}</h1>
                </div>

                <!-- Event Description -->
                <div class="prose max-w-none text-slate-600 leading-relaxed text-sm whitespace-pre-line font-sans mb-8">
                    {{ $event->description }}
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t-2 border-slate-800">
                    <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center justify-center px-6 py-3 bg-cyan-100 hover:bg-cyan-200 active:bg-cyan-300 text-cyan-800 font-bold text-sm rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition duration-150 cursor-pointer">
                        ✏️ Edit Acara
                    </a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-rose-100 hover:bg-rose-200 active:bg-rose-300 text-rose-800 font-bold text-sm rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition duration-150 cursor-pointer">
                            🗑️ Hapus Acara
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
