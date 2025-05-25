@extends('layouts.dashboard')

@section('content')
<div x-data="{ 
    openEditProfile: false, 
    openChangePassword: false, 
    changePasswordLoading: false, 
    changePasswordError: '', 
    changePasswordSuccess: '', 
    current_password: '', 
    new_password: '', 
    new_password_confirmation: '',
    forgotPasswordLoading: false,
    forgotPasswordError: '',
    forgotPasswordSuccess: ''
}" class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Profile Information Section -->
                <div class="flex-1 w-full">
                    <h2 class="text-xl font-normal font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-3">My Profile</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Username</span>
                                <span class="text-gray-800">{{ Auth::guard('customer')->user()->username }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Full Name</span>
                                <span class="text-gray-800">{{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->last_name }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Email</span>
                                <span class="text-gray-800">{{ Str::mask(Auth::guard('customer')->user()->email, '*', 2, strpos(Auth::guard('customer')->user()->email, '@') - 2) }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Phone</span>
                                <span class="text-gray-800">********{{ substr(Auth::guard('customer')->user()->phone_number, -4) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Address</span>
                                <span class="text-gray-800">{{ Auth::guard('customer')->user()->address }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Gender</span>
                                <span class="text-gray-800">{{ ucfirst(Auth::guard('customer')->user()->gender) ?? 'N/A' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Date of Birth</span>
                                <span class="text-gray-800">{{ Auth::guard('customer')->user()->date_of_birth ? Auth::guard('customer')->user()->date_of_birth->format('F d, Y') : '****' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="font-normal text-gray-600 block mb-0.5">Password</span>
                                <div class="flex items-center">
                                    <span class="text-gray-800">********</span>
                                    <button @click.prevent="openChangePassword = true" 
                                            class="ml-2 text-[#7464B6] hover:text-[#6454A6] text-sm font-normal transition-colors duration-200">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button @click="openEditProfile = true" 
                                class="font-normal bg-[#7464B6] text-white px-5 py-2 rounded-md hover:bg-[#6454A6] transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('customers.edit-profile-modal', ['openBinding' => 'openEditProfile'])
    @include('customers.change-password')
</div>
@endsection

