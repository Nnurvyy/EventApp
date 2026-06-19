<x-app-layout>
    <style>[x-cloak] { display: none !important; }</style>
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
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="inline-flex items-center gap-1.5 bg-teal-100 text-teal-800 border-2 border-slate-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                            📅 {{ $event->event_date->format('d M Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-800 border-2 border-slate-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                            💰 {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-800 leading-tight">{{ $event->title }}</h1>
                </div>

                <!-- Event Description -->
                <div class="prose max-w-none text-slate-600 leading-relaxed text-sm whitespace-pre-line font-sans mb-8">
                    {{ $event->description }}
                </div>

                <!-- Registration / Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-slate-800">
                    <span class="text-xs text-slate-400 font-semibold">
                        @if($event->price == 0)
                            * Pendaftaran gratis dan instan.
                        @else
                            * Biaya pendaftaran: Rp {{ number_format($event->price, 0, ',', '.') }}.
                        @endif
                    </span>
                    @if ($isRegistered)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 border-2 border-slate-800 font-bold text-sm px-6 py-3 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]">
                            Sudah Terdaftar ✓
                        </span>
                    @else
                        <div x-data="{ showConfirmModal: false }">
                            <form action="{{ route('events.register', $event) }}" method="POST" id="register-form">
                                @csrf
                                <button type="button" @click="showConfirmModal = true" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 font-bold text-sm text-white rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition transform hover:scale-102 active:scale-98 duration-150 cursor-pointer">
                                    Daftar Acara ✨
                                </button>
                            </form>

                            <!-- Cute Neo-brutalist Confirmation Modal -->
                            <div x-show="showConfirmModal" 
                                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 x-cloak>
                                <div @click.away="showConfirmModal = false" class="bg-white border-4 border-slate-800 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] rounded-3xl p-6 text-center relative mx-auto" style="max-width: 360px; width: 100%; box-sizing: border-box;">
                                    <div class="bg-amber-100 border-2 border-slate-800 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" style="width: 64px; height: 64px; min-width: 64px; min-height: 64px;">
                                        🎫
                                    </div>
                                    <h3 class="text-xl font-black text-slate-800 mb-2">Konfirmasi Pendaftaran</h3>
                                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                                        Apakah Anda yakin ingin mendaftar ke acara <span class="font-bold text-slate-800">"{{ $event->title }}"</span>? Email tiket konfirmasi akan langsung dikirimkan ke alamat Anda.
                                    </p>
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" @click="showConfirmModal = false" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 border-2 border-slate-800 rounded-xl font-bold text-xs text-slate-700 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer transition active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]">
                                            Batal
                                        </button>
                                        <button type="button" @click="document.getElementById('register-form').submit()" class="flex-1 px-4 py-2.5 bg-teal-500 hover:bg-teal-600 text-white border-2 border-slate-800 rounded-xl font-bold text-xs shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] cursor-pointer transition active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]">
                                            Ya, Daftar! 🚀
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
