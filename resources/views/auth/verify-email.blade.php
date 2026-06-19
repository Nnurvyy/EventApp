<x-guest-layout>
    <div class="mb-5 text-sm text-slate-500 bg-slate-50/50 border border-slate-100 p-4 rounded-2xl leading-relaxed">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan. Jika Anda tidak menerimanya, kami akan mengirimkan ulang dengan senang hati.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-semibold rounded-2xl">
            {{ __('Link verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat registrasi.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
            @csrf
            <button type="submit" class="text-sm font-bold text-slate-500 hover:text-teal-600 transition-colors focus:outline-none">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
