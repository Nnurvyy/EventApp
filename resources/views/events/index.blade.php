<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Katalog Acara 🔍') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($events->isEmpty())
                <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl p-12 text-center">
                    <div class="text-5xl mb-4">🎈</div>
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada Acara</h3>
                    <p class="text-slate-500 text-sm mt-1">Silakan kembali lagi nanti untuk melihat daftar acara terbaru kami.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-x-0.5 hover:-translate-y-0.5 transform transition duration-200 rounded-3xl flex flex-col justify-between overflow-hidden">
                            <!-- Card Image -->
                            <div class="relative h-48 overflow-hidden flex-none border-b-2 border-slate-800">
                                @if ($event->event_picture)
                                    <img src="{{ asset('storage/' . $event->event_picture) }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
                                @else
                                    <x-event-placeholder class="w-full h-full" />
                                @endif
                                <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-white text-slate-800 border-2 border-slate-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                                    📅 {{ $event->event_date->format('d M Y') }}
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <!-- Event Title -->
                                    <h3 class="text-lg font-bold text-slate-800 mb-2 leading-snug line-clamp-2">
                                        {{ $event->title }}
                                    </h3>
                                    
                                    <!-- Event Excerpt -->
                                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-3 mb-6">
                                        {{ $event->description }}
                                    </p>
                                </div>
                                
                                <!-- Actions -->
                                <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                                    <span class="text-xs font-semibold text-slate-400">Terbuka</span>
                                    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-xs text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:scale-102 active:scale-98 transform transition duration-150 cursor-pointer">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cute Pagination -->
                <div class="mt-8">
                    {{ $events->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
