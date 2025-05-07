<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($request->is('admin/login')) {
            return view('auth.login'); // Admin login view
        } else {
            return view('subviews.login'); // User login view
        }
    }

    public function login(Request $request)
    {
        if ($request->is('admin/login')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return redirect()->route('admin.dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } else {
            // Customer login
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('customer')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return redirect('/test');
            } else {
                return back()->withErrors(['email' => 'Invalid credentials.']);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
} 