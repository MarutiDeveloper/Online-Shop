<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class GoogleController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            // Retrieve the user from Google
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);
            // Check if the user already exists in the database by email
            // $existingUser = User::where('email', $googleUser->getEmail())->first();
            $existingUser = User::where('google_id', $googleUser->getId())->first();

            if (!$existingUser) {
              
                  // If the user doesn't exist, create a new user
                  $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make('123@example'), // Set a default or random password
                ]);
                // $newUser->save();
                 // Log in the newly created user
                 Auth::login($newUser);
            } else {
                // If the user exists, log them in
                Auth::login($existingUser);
 
            }

            // Redirect to home or intended page
            return redirect()->route('account.profile');
        } catch (Exception $e) {
            // If there is an error, redirect back to the login page with an error message
            return redirect()->route('account.login')->with('error', 'Failed to login with Google. Please try again.');
        }
    }
}
