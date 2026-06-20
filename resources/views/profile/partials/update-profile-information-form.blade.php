<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Profile -->
        <div x-data="{ avatarPreview: null }" class="flex flex-col items-center sm:items-start gap-4">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <div class="flex items-center gap-4">
                <!-- Current Avatar / New Preview -->
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
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
