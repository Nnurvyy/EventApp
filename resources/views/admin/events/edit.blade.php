<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150" title="Kembali">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Edit Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-md overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/50 rounded-3xl">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Acara')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus placeholder="Masukkan nama/judul acara..." />
                            @error('title')
                                <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Date -->
                        <div>
                            <x-input-label for="event_date" :value="__('Tanggal Pelaksanaan')" />
                            <x-text-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" :value="old('event_date', $event->event_date->format('Y-m-d'))" required />
                            @error('event_date')
                                <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Acara')" />
                            <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-slate-200 focus:border-teal-400 focus:ring-teal-200 focus:ring rounded-2xl shadow-sm text-slate-800 transition duration-150 bg-white/70 backdrop-blur-sm p-4 font-sans text-sm focus:outline-none" required placeholder="Jelaskan detail mengenai acara ini secara rinci...">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-full shadow-sm hover:bg-slate-50 active:bg-slate-100 transition duration-150 cursor-pointer">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui Acara') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
