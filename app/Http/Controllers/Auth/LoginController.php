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

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->is_admin) {
                    return redirect()->route('admin.dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'You do not have admin privileges.',
                    ]);
                }
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

            if (Auth::guard('customer')->attempt($credentials)) {
                $customer = Auth::guard('customer')->user();
                
                // Check if profile is complete
                if (
                    !empty($customer->first_name) &&
                    !empty($customer->last_name) &&
                    !empty($customer->phone_number) &&
                    !empty($customer->address)
                ) {
                    return redirect()->route('dashboard');
                }
                
                return redirect()->route('customer.profile.check');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        if ($request->is('admin/logout')) {
            Auth::guard('web')->logout();
        } else {
            Auth::guard('customer')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if ($request->is('admin/logout')) {
            return redirect()->route('admin.login');
        }
        return redirect()->route('login');
    }
} 