<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Edit Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Event Picture (1:1 Aspect Ratio Preview on Top) -->
                        <div class="flex flex-col items-center">
                            <x-input-label for="event_picture" :value="__('Foto Acara')" class="self-start mb-2" />
                            
                            <!-- 1:1 Aspect Ratio Image Preview Container -->
                            <div class="w-48 h-48 mx-auto mb-4 border-2 border-slate-800 rounded-3xl overflow-hidden shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] relative bg-slate-50 flex items-center justify-center flex-shrink-0">
                                @if ($event->event_picture)
                                    <img src="{{ asset('storage/' . $event->event_picture) }}" id="image-preview" class="w-full h-full object-cover" alt="Foto Acara">
                                @else
                                    <x-event-placeholder id="image-preview-placeholder" class="w-full h-full" />
                                    <img id="image-preview" class="w-full h-full object-cover hidden" alt="Pratinjau Foto">
                                @endif
                            </div>

                            <!-- Upload Button & File Name -->
                            <div class="flex flex-col items-center gap-1.5 w-full mb-2">
                                <label class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 font-bold text-xs rounded-full border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition duration-150 cursor-pointer w-fit">
                                    <span>📁 Ubah Gambar</span>
                                    <input id="event_picture" type="file" name="event_picture" class="hidden" accept="image/*" onchange="previewImage(event)">
                                </label>
                                <span id="file-name" class="text-xs text-slate-400 font-medium">Belum ada file baru dipilih</span>
                            </div>

                            @error('event_picture')
                                <p class="text-rose-500 text-xs font-semibold mt-1 self-start">{{ $message }}</p>
                            @enderror
                        </div>

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

                        <!-- Pricing Section -->
                        <div x-data="{ priceType: '{{ old('price_type', $event->price > 0 ? 'paid' : 'free') }}', price: '{{ old('price', $event->price > 0 ? $event->price : '') }}' }" class="space-y-4">
                            <div>
                                <x-input-label :value="__('Tipe Tiket / Biaya Masuk')" class="mb-2" />
                                <input type="hidden" name="price_type" :value="priceType">
                                <div class="flex items-center gap-4">
                                    <!-- Gratis Button -->
                                    <button type="button" 
                                            @click="priceType = 'free'" 
                                            :class="priceType === 'free' ? 'bg-emerald-400 text-slate-800' : 'bg-slate-50 text-slate-500 hover:bg-slate-100'"
                                            class="px-6 py-3 border-2 border-slate-800 rounded-2xl font-bold text-sm shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all duration-150 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                                        🆓 Gratis
                                    </button>
                                    
                                    <!-- Berbayar Button -->
                                    <button type="button" 
                                            @click="priceType = 'paid'" 
                                            :class="priceType === 'paid' ? 'bg-amber-400 text-slate-800' : 'bg-slate-50 text-slate-500 hover:bg-slate-100'"
                                            class="px-6 py-3 border-2 border-slate-800 rounded-2xl font-bold text-sm shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all duration-150 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                                        💳 Berbayar
                                    </button>
                                </div>
                                @error('price_type')
                                    <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price Input Box -->
                            <div x-show="priceType === 'paid'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="mt-3">
                                <x-input-label for="price" :value="__('Harga Tiket (Rupiah)')" class="mb-1" />
                                <div class="relative flex items-center max-w-xs">
                                    <span class="absolute left-4 text-sm font-extrabold text-slate-800">Rp</span>
                                    <x-text-input id="price" class="block w-full pl-11 pr-4 font-bold text-slate-800" type="number" name="price" x-model="price" placeholder="150000" />
                                </div>
                                @error('price')
                                    <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
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
                        <div class="flex items-center justify-end gap-3 pt-6 border-t-2 border-slate-800">
                            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-slate-800 text-slate-600 font-bold text-sm rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:bg-slate-50 active:bg-slate-100 transition duration-150 cursor-pointer">
                                Batal
                            </a>
                            <x-primary-button class="border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)]">
                                {{ __('Perbarui Acara') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to handle image preview -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const fileNameSpan = document.getElementById('file-name');
            const previewImage = document.getElementById('image-preview');
            const placeholder = document.getElementById('image-preview-placeholder');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                fileNameSpan.textContent = file.name;

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            } else {
                fileNameSpan.textContent = "Belum ada file baru dipilih";
            }
        }
    </script>
</x-app-layout>
