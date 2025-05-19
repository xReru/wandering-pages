<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function showSignupForm()
    {
        return view('subviews.signup');
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/',
            ],
        ], [
            'password-min' => ' ',
            'username.regex' => 'Username must be at least 4 characters and include only letters, numbers, and underscores.',
            'password.regex' => 'Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one special character.',
            'email.unique' => 'This email address is already registered. Please use a different email or try logging in.'
        ]);

        $customer = Customer::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully. Please log in.');
    }
} 