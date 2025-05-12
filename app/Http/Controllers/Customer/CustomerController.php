<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $image->storeAs('public/profile_pictures', $imageName);
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
            $image->storeAs('public/profile_pictures', $imageName);
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
} 