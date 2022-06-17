<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $google = Socialite::driver('google')->user();

        $user = User::whereGoogleId($google->getId())->first();
        if ($user) {
            Auth::loginUsingId($user->id);
            return redirect()->route('home');
        }
        $user = User::whereEmail($google->getEmail())->first();
        if ($user) {
            $user->google_id = $google->getId();
            $user->save();
            Auth::loginUsingId($user->id);
            return redirect()->route('home');
        }

        $post = User::create([
            'name' => $google->getName(),
            'email' => $google->getEmail(),
            'image' => $google->getAvatar(),
            'type' => 2, // user
            'google_id' => $google->getId()
        ]);
        Log::info("New User", ['data' => $post]);
        $post->assignRole('user');
        Auth::loginUsingId($post->id);
        return redirect()->route('home');
    }
}
