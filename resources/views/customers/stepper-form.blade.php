@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-2 text-center">Build Your Profile</h2>
        <p class="text-gray-500 mb-6 text-center">This information will let us know more about you.</p>

        <div x-data="{ step: 1 }">
            <!-- Stepper Navigation -->
            <div class="flex justify-between mb-8">
                <div :class="step === 1 ? 'font-bold text-blue-600' : 'text-gray-400'">About</div>
                <div :class="step === 2 ? 'font-bold text-blue-600' : 'text-gray-400'">Phone</div>
                <div :class="step === 3 ? 'font-bold text-blue-600' : 'text-gray-400'">Address</div>
            </div>

            <form method="POST" action="{{ route('customer.profile.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: About -->
                <div x-show="step === 1" x-cloak>
                    <div class="flex flex-col items-center mb-4">
                        <label class="relative cursor-pointer">
                            <img id="profilePreview" src="{{ old('profile_picture') ? asset('storage/' . old('profile_picture')) : 'https://via.placeholder.com/100x100?text=Photo' }}" class="w-24 h-24 rounded-lg object-cover mb-2" />
                            <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="document.getElementById('profilePreview').src = window.URL.createObjectURL(this.files[0])">
                            <span class="absolute bottom-2 right-2 bg-blue-600 text-white rounded-full p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2a2.828 2.828 0 11-4-4 2.828 2.828 0 014 4z"></path>
                                </svg>
                            </span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. Michael" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. Tomson" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="step = 2" class="px-4 py-2 bg-blue-600 text-white rounded">Next</button>
                    </div>
                </div>

                <!-- Step 2: Phone -->
                <div x-show="step === 2" x-cloak>
                    <div class="mb-4">
                        <label class="block text-gray-700">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. +1234567890" required>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" @click="step = 1" class="px-4 py-2 bg-gray-200 rounded">Back</button>
                        <button type="button" @click="step = 3" class="px-4 py-2 bg-blue-600 text-white rounded">Next</button>
                    </div>
                </div>

                <!-- Step 3: Address -->
                <div x-show="step === 3" x-cloak>
                    <div class="mb-4">
                        <label class="block text-gray-700">Complete Address</label>
                        <textarea name="address" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. 123 Main St, City, Country" required>{{ old('address') }}</textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" @click="step = 2" class="px-4 py-2 bg-gray-200 rounded">Back</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Finish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection