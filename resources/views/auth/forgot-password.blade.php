<x-guest-layout>
    <div class="mb-5 text-sm text-slate-500 bg-slate-50/50 border border-slate-100 p-4 rounded-2xl leading-relaxed">
        {{ __('Lupa password? Jangan khawatir! Cukup masukkan alamat email Anda dan kami akan mengirimkan link reset password untuk membuat yang baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8 flex flex-col gap-4">
            <x-primary-button class="w-full">
                {{ __('Kirim Link Reset Password') }}
            </x-primary-button>

            <div class="text-center mt-2">
                <a href="{{ route('login') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 transition-colors">Kembali ke Login</a>
            </div>
        </div>
    </form>
</x-guest-layout>
