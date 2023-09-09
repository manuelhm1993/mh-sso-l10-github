<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $user = User::updateOrCreate([
            'email' => $userSocial->email
            ],
            [
                'name' => $userSocial->name,
                'avatar_url' => $userSocial->avatar,
                'password' => $userSocial->email
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
