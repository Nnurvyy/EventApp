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

            <div class="relative my-2 flex items-center justify-center">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <span class="relative bg-white px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Atau</span>
            </div>

            <a href="{{ route('auth.google') }}" class="w-full inline-flex items-center justify-center gap-3 px-6 py-3 bg-white border border-slate-200 rounded-full font-bold text-sm text-slate-600 hover:bg-slate-50 hover:border-teal-200 hover:text-slate-800 transition duration-200 shadow-sm hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transform cursor-pointer">
                <svg class="h-5 w-5" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.68 1.54 14.98 1 12 1 7.35 1 3.37 3.67 1.39 7.56l3.89 3.02C6.2 7.78 8.89 5.04 12 5.04z"/>
                    <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.36H12v4.51h6.46c-.28 1.48-1.12 2.74-2.38 3.58l3.69 2.87c2.16-1.99 3.72-4.92 3.72-8.6z"/>
                    <path fill="#FBBC05" d="M5.28 10.58c-.24-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29L1.39 7.56c-.83 1.66-1.3 3.53-1.3 5.51s.47 3.85 1.3 5.51l3.89-3.02z"/>
                    <path fill="#34A853" d="M12 18.96c-3.11 0-5.8-2.74-6.72-5.54l-3.89 3.02C3.37 20.33 7.35 23 12 23c3.15 0 6.06-1.05 8.16-2.88l-3.69-2.87c-1.12.75-2.58 1.71-4.47 1.71z"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>

            <div class="text-center mt-2">
                <span class="text-sm text-slate-400 font-medium">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 transition-colors ms-1">Daftar sekarang</a>
            </div>
        </div>
    </form>
</x-guest-layout>
