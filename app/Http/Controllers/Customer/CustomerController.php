<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function showStepperForm()
    {
        $customer = auth()->guard('customer')->user();
        
        // If all required fields are present, redirect to dashboard
        if (
            !empty($customer->first_name) &&
            !empty($customer->last_name) &&
            !empty($customer->phone_number) &&
            !empty($customer->address) &&
            !empty($customer->gender) &&
            !empty($customer->date_of_birth)
        ) {
            return redirect()->route('dashboard');
        }

        return view('customers.stepper-form', compact('customer'));
    }

    public function checkProfile()
    {
        $customer = auth()->guard('customer')->user();
        
        // Check if all required fields are present
        if (
            !empty($customer->first_name) &&
            !empty($customer->last_name) &&
            !empty($customer->phone_number) &&
            !empty($customer->address) &&
            !empty($customer->gender) &&
            !empty($customer->date_of_birth)
        ) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('customer.profile.setup');
    }

    public function storeStepperForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today'
        ]);

        $customer = auth()->guard('customer')->user();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('profile_pictures', $imageName, 'public');
            $customer->profile_picture = 'profile_pictures/' . $imageName;
        }

        // Update customer information
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->phone_number = $validated['phone_number'];
        $customer->address = $validated['address'];
        $customer->gender = $validated['gender'];
        $customer->date_of_birth = $validated['date_of_birth'];
        $customer->save();

        return redirect()->route('dashboard')->with('success', 'Profile completed successfully!');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . Auth::guard('customer')->id(),
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today'
        ]);

        $customer = Auth::guard('customer')->user();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('profile_pictures', $imageName, 'public');
            $customer->profile_picture = 'profile_pictures/' . $imageName;
        }

        // Update customer information
        $customer->username = $validated['username'];
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->email = $validated['email'];
        $customer->phone_number = $validated['phone_number'];
        $customer->address = $validated['address'];
        $customer->gender = $validated['gender'];
        $customer->date_of_birth = $validated['date_of_birth'];
        $customer->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/',
                'confirmed',
            ],
        ], [
            'new_password.regex' => 'Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one special character.'
        ]);

        $customer = Auth::guard('customer')->user();
        if (!\Hash::check($request->current_password, $customer->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 422);
        }
        $customer->password = \Hash::make($request->new_password);
        $customer->save();
        return response()->json(['success' => 'Password changed successfully.']);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $customer = \App\Models\Customer::where('email', $request->email)->first();
        if (!$customer) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Generate a new password reset token
        $token = Str::random(64);
        $customer->password_reset_token = $token;
        $customer->password_reset_token_expires_at = now()->addHours(24);
        $customer->save();

        // Send the password reset email
        \Mail::send('emails.reset-password', ['token' => $token, 'customer' => $customer], function($message) use ($customer) {
            $message->to($customer->email);
            $message->subject('Password Reset Request');
        });

        return response()->json(['success' => 'Password reset link has been sent to your email.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/',
                'confirmed',
            ],
        ], [
            'password.regex' => 'Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one special character.'
        ]);

        $customer = \App\Models\Customer::where('email', $request->email)
            ->where('password_reset_token', $request->token)
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        if (!$customer) {
            return response()->json(['error' => 'Invalid or expired reset token.'], 422);
        }

        try {
            $customer->password = Hash::make($request->password);
            $customer->password_reset_token = null;
            $customer->password_reset_token_expires_at = null;
            $customer->save();

            return response()->json(['success' => 'Password has been reset successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reset password. Please try again.'], 500);
        }
    }
} 