<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center p-2 bg-slate-100 text-slate-600 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition duration-150 border-2 border-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]" title="Kembali">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Edit User: ') }} {{ $user->name }} 👤
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-slate-800 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] rounded-3xl p-6 md:p-8">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Avatar Profile Edit -->
                    <div x-data="{ avatarPreview: null }" class="flex flex-col items-center sm:items-start gap-4">
                        <label for="avatar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Profil</label>
                        
                        <div class="flex items-center gap-4">
                            <!-- Preview Container -->
                            <div class="relative">
                                <template x-if="!avatarPreview">
                                    <x-user-avatar :user="$user" class="w-20 h-20" />
                                </template>
                                <template x-if="avatarPreview">
                                    <img :src="avatarPreview" class="w-20 h-20 rounded-full object-cover border-2 border-slate-800 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]">
                                </template>
                            </div>
                            
                            <!-- File Input Trigger -->
                            <div class="flex flex-col gap-1.5">
                                <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" 
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { avatarPreview = e.target.result; }; reader.readAsDataURL(file); }">
                                <button type="button" onclick="document.getElementById('avatar').click()" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 border-2 border-slate-800 rounded-xl font-bold text-xs shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer">
                                    Pilih Foto 📁
                                </button>
                                <span class="text-[10px] text-slate-400 font-medium">Maksimal ukuran berkas 2MB (JPG, PNG, WebP)</span>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus class="w-full text-xs font-semibold px-4 py-3 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full text-xs font-semibold px-4 py-3 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Selection (Alpine.js Interactive Pills) -->
                    <div x-data="{ role: '{{ old('role', $user->role) }}' }">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Peran (Role)</label>
                        <input type="hidden" name="role" :value="role">
                        
                        <div class="flex gap-4">
                            <!-- Regular User Pill -->
                            <button type="button" @click="role = 'user'" :class="role === 'user' ? 'bg-teal-100 border-teal-500 text-teal-800 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]' : 'bg-slate-50 border-slate-200 text-slate-500'" class="flex-1 py-3 px-4 border-2 border-slate-800 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 cursor-pointer transition transform active:scale-98 duration-100">
                                👤 User Biasa
                            </button>
                            <!-- Admin Pill -->
                            <button type="button" @click="role = 'admin'" :class="role === 'admin' ? 'bg-rose-100 border-rose-500 text-rose-800 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]' : 'bg-slate-50 border-slate-200 text-slate-500'" class="flex-1 py-3 px-4 border-2 border-slate-800 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 cursor-pointer transition transform active:scale-98 duration-100">
                                👑 Administrator
                            </button>
                        </div>
                        @error('role')
                            <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi Baru</label>
                            <span class="text-[10px] font-semibold text-slate-400">* Kosongkan jika tidak ingin mengubah</span>
                        </div>
                        <input type="password" name="password" id="password" class="w-full text-xs font-semibold px-4 py-3 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full text-xs font-semibold px-4 py-3 border-2 border-slate-800 rounded-xl focus:outline-none focus:ring-0 focus:border-teal-500 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] bg-white">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100">
                        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 border-2 border-slate-800 rounded-xl font-bold text-xs shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white border-2 border-slate-800 rounded-xl font-bold text-xs shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] transition cursor-pointer">
                            Simpan Perubahan 🚀
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
