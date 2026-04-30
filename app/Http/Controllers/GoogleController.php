<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Google_Client;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // tanpa stateless() — ini menggunakan session (default)
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            // pakai stateless biar aman dari masalah session di local
            $driver = Socialite::driver('google');
            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $googleUser = $driver->stateless()->user();
        } catch (\Throwable $e) {
            Log::error('Google OAuth (stateless) failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('login') // ganti dengan route login kamu jika beda
                ->with('error', 'Gagal login dengan Google, silakan coba lagi.');
        }

        // Ambil data penting
        $googleId = $googleUser->getId();
        $email    = $googleUser->getEmail();
        $name     = $googleUser->getName() ?? $googleUser->getNickname() ?? 'User';
        $avatar   = $googleUser->getAvatar();

        // Cari akun existing (prioritas google_id lalu email)
        $account = Account::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        try {
            if (! $account) {
                // buat username unik
                $baseUsername = Str::slug(explode(' ', $name)[0] ?? $name);
                $username = $baseUsername ?: 'user';
                $counter = 0;
                while (Account::where('username', $username)->exists()) {
                    $counter++;
                    $username = $baseUsername . $counter;
                }

                // simpan avatar (jika ada)
                $photoPath = null;
                if ($avatar) {
                    try {
                        $contents = @file_get_contents($avatar);
                        if ($contents !== false) {
                            $filename = 'profile/google-' . Str::random(10) . '.jpg';
                            // store returns path like 'profile/xxx.jpg' if using store, but here we already build filename
                            Storage::disk('public')->put('profile/' . $filename, $contents);
                            $photoPath = 'profile/' . $filename;
                        }
                    } catch (\Exception $ex) {
                        Log::warning('Failed to save google avatar: ' . $ex->getMessage());
                        $photoPath = null;
                    }
                }

                // create account (pastikan $fillable di model Account mencakup fields berikut)
                $account = Account::create([
                    'nama_lengkap'  => $name,
                    'username'      => $username,
                    'email'         => $email,
                    'password'      => Hash::make(Str::random(32)),
                    'role'          => 'user',
                    'photo'         => $photoPath,         // optional
                    'google_avatar' => $photoPath,         // simpan juga di kolom google_avatar
                    'google_id'     => $googleId,
                    'is_active'     => 1,
                    'last_login_at' => now(),
                ]);
            } else {
                // update account jika perlu
                $update = [];
                if (! $account->google_id) $update['google_id'] = $googleId;
                if ($name && $name !== $account->nama_lengkap) $update['nama_lengkap'] = $name;

                if ($avatar && ! $account->google_avatar) {
                    try {
                        $contents = @file_get_contents($avatar);
                        if ($contents !== false) {
                            $filename = 'profile/google-' . Str::random(10) . '.jpg';
                            Storage::disk('public')->put('profile/' . $filename, $contents);
                            $update['google_avatar'] = 'profile/' . $filename;
                            // optionally set photo too:
                            if (! $account->photo) $update['photo'] = 'profile/' . $filename;
                        }
                    } catch (\Exception $ex) {
                        Log::warning('Failed to save google avatar on update: ' . $ex->getMessage());
                    }
                }

                $update['is_active'] = 1;
                $update['last_login_at'] = now();

                if (! empty($update)) {
                    $account->update($update);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Failed to create/update account from Google: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('login')->with('error', 'Terjadi masalah saat membuat akun. Cek log.');
        }

        // login user (false = no remember). Jika ingin remember, ubah ke true setelah menambah kolom remember_token.
        Auth::login($account, false);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }


    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'id_token' => 'required'
        ]);

        $client = new Google_Client([
            'client_id' => env('GOOGLE_CLIENT_ID')
        ]);

        $payload = $client->verifyIdToken($request->id_token);

        if (!$payload) {
            return response()->json([
                'message' => 'Invalid Google token'
            ], 401);
        }

        $email = $payload['email'];
        $name = $payload['name'];
        $googleId = $payload['sub'];

        $account = Account::where('email', $email)
            ->orWhere('google_id', $googleId)
            ->first();

        if (!$account) {
            // Generate unique username
            $baseUsername = Str::slug(explode(' ', $name)[0] ?? $name);
            $username = $baseUsername ?: 'user';
            $counter = 0;
            while (Account::where('username', $username)->exists()) {
                $counter++;
                $username = $baseUsername . $counter;
            }

            $account = Account::create([
                'nama_lengkap' => $name,
                'username' => $username,
                'email' => $email,
                'google_id' => $googleId,
                'password' => bcrypt(Str::random(16)),
                'role' => 'user',
                'is_active' => 1,
                'last_login_at' => now(),
            ]);
        } else {
            // Update existing account if needed
            $update = ['last_login_at' => now()];
            if (!$account->google_id) $update['google_id'] = $googleId;
            $account->update($update);
        }

        $token = $account->createToken('mobile')->plainTextToken;

        return response()->json([
            'user' => $account,
            'token' => $token
        ]);
    }
}
