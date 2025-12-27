<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Unable to login with Google. Please try again.');
        }

        // 1) Try to find by google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        // 2) If not found, try by email
        if (!$user && $googleUser->getEmail()) {
            $user = User::where('email', $googleUser->getEmail())->first();
        }

        // 3) Create new user if needed
        if (!$user) {
            $user = User::create([
                'name'      => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                'email'     => $googleUser->getEmail(),
                'password'  => Hash::make(uniqid('google_', true)), // random password
                'google_id' => $googleUser->getId(),
            ]);

            // default role
            $user->assignRole('user');
        } else {
            // attach google_id if missing
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        // Login & remember the user
        Auth::login($user, true);

        return redirect()->route('home');
    }
}
