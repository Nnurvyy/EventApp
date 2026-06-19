<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
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

                <!-- Registration / Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-slate-800">
                    <span class="text-xs text-slate-400 font-semibold">
                        * Pendaftaran gratis dan instan.
                    </span>
                    @if ($isRegistered)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 border-2 border-slate-800 font-bold text-sm px-6 py-3 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                            Sudah Terdaftar ✓
                        </span>
                    @else
                        <form action="{{ route('events.register', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition transform hover:scale-102 active:scale-98 duration-150 cursor-pointer">
                                Daftar Acara ✨
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
