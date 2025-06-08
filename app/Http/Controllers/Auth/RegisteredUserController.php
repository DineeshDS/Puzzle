<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request)
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validate input (skip unique:users to allow existing users)
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // Try to find user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, log them in
            Auth::login($user);
            return $this->apiResponse($user, 'You are logged in successfully!');
        } else {
            // If user doesn't exist, create and log in
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make('1@Clicker'), // Default password
            ]);

            Auth::login($user);
            return $this->apiResponse($user, 'You are successfully registered and logged in!');
        }
    }
}
