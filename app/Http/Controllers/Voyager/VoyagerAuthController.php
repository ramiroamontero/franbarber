<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerAuthController as BaseVoyagerAuthController;
use App\Models\User;
use Socialite;
use TCG\Voyager\Facades\Voyager;

class VoyagerAuthController extends BaseVoyagerAuthController
{
    public function login()
    {
        if ($this->guard()->user()) {
            return redirect()->route('voyager.dashboard');
        }

        return Voyager::view('voyager::login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('voyager.login')
                ->withErrors(['google' => 'Google authentication failed.']);
        }

        $user = User::updateOrCreate(['email' => $googleUser->email], [
            'name' => $googleUser->name,
            'password' => bcrypt(str()->random(16)),
            'google_id' => $googleUser->id,
        ]);

        auth()->login($user);
        session(['google_token' => $googleUser->token]);

        return redirect()->intended(route('voyager.dashboard'));
    }
}
