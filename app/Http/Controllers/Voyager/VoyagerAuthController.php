<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;
use App\Models\User;
use TCG\Voyager\Http\Controllers\VoyagerAuthController as BaseVoyagerAuthController;

class VoyagerAuthController extends BaseVoyagerAuthController
{
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function googleLogin()
    {
        return \Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('voyager.login')->withErrors(['google' => 'Google authentication failed.']);
        }

        // Find or create user logic (customize as needed)
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
                // Add other fields if needed
            ]);
        }

        auth()->login($user);

        return redirect()->intended(route('voyager.dashboard'));
    }
}
