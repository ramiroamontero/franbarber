<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerAuthController as BaseVoyagerAuthController;
use App\Models\User;
use Log;
use Socialite;

class VoyagerAuthController extends BaseVoyagerAuthController
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        Log::info('handle_google_callback IN_PROGRESS');
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            Log::error('handle_google_callback', ['error' => $e->getMessage()]);
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
        Log::info('handle_google_callback SUCCESS');

        return redirect()->intended(route('voyager.dashboard'));
    }
}
