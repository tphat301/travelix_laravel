<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function getInfoGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackLoginGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $exception) {
            return redirect('/login');
        }
        $existUser = User::where('email', $googleUser->getEmail())->first();
        if ($existUser) {
            auth()->login($existUser, true);
            return redirect('/dashboard');
        } else {
            if ($existUser == "") {
                $user = User::create(
                    [
                        'email' => $googleUser->getEmail(),
                        'username' => $googleUser->getEmail(),
                        'name' => $googleUser->getName(),
                        'level' => 2,
                        'status' => 'active',
                        'role' => 'client',
                        'password' => Hash::make('admin123'),
                        'google_id' => $googleUser->getId(),
                    ]
                );
            }
            auth()->login($user, true);
            return redirect('/dashboard');
        }
    }
}
