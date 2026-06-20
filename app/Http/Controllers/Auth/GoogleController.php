<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and log them in.
     *
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Jika user ditemukan tapi belum terhubung dengan google_id atau belum memiliki avatar, update
                $updateData = [];
                if (empty($user->google_id)) {
                    $updateData['google_id'] = $googleUser->getId();
                }
                if (empty($user->avatar) && $googleUser->getAvatar()) {
                    $updateData['avatar'] = $googleUser->getAvatar();
                }
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } else {
                // Jika user belum terdaftar, buat akun baru
                $user = User::create([
                    'name' => $googleUser->getName() ?? explode('@', $googleUser->getEmail())[0],
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'user', // Role default untuk registrasi biasa
                ]);
            }

            // Login-kan user dan aktifkan 'remember me'
            Auth::login($user, true);

            // Regenerate session untuk keamanan
            session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (Exception $e) {
            // Log error jika ada masalah otentikasi
            logger()->error('Google Auth Error: ' . $e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk menggunakan Google. Silakan coba beberapa saat lagi.',
            ]);
        }
    }
}
