<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12"
                                ::type="showPassword ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 transition-colors focus:outline-none">
                    <!-- Eye Open Icon -->
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Closed Icon -->
                    <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-teal-500 shadow-sm focus:ring-teal-200 focus:ring focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-slate-500 font-medium hover:text-slate-700 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-teal-600 hover:text-teal-700 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8 flex flex-col gap-4">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="text-center mt-2">
                <span class="text-sm text-slate-400 font-medium">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 transition-colors ms-1">Daftar sekarang</a>
            </div>
        </div>
    </form>
</x-guest-layout>
