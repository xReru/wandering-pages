@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-2 text-center">Build Your Profile</h2>
        <p class="text-gray-500 mb-6 text-center">This information will let us know more about you.</p>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div x-data="{
            step: {{ old('step', 1) }},
            setStep(newStep) {
                this.step = newStep;
                document.getElementById('current_step').value = newStep;
            },
            // Step 1 fields
            first_name: '{{ old('first_name') }}',
            last_name: '{{ old('last_name') }}',
            gender: '{{ old('gender') }}',
            date_of_birth: '{{ old('date_of_birth') }}',
            // Step 2 field
            phone_number: '{{ old('phone_number') }}',
            // Step 3 field
            address: `{{ old('address') }}`,
            get isStep1Valid() {
                return this.first_name && this.last_name && this.gender && this.date_of_birth;
            },
            get isStep2Valid() {
                return this.phone_number;
            },
            get isStep3Valid() {
                return this.address;
            }
        }">
            <!-- Stepper Navigation -->
            <div class="flex items-center justify-between mb-8 w-full">
                <!-- Step 1: About -->
                <div class="flex flex-col items-center ">
                    <div :class="step === 1 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400'" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-200">
                        <!-- About Icon -->
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <span class="mt-2 text-sm font-medium" :class="step === 1 ? 'text-gray-900' : 'text-gray-400'">About</span>
                </div>
                <!-- Line between steps -->
                <div class="flex-1 h-1 bg-gray-300 mx-2 mb-5"></div>
                <!-- Step 2: Phone -->
                <div class="flex flex-col items-center ">
                    <div :class="step === 2 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400'" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-200">
                        <!-- Phone Icon -->
                        <i class="fas fa-phone text-lg"></i>
                    </div>
                    <span class="mt-2 text-sm font-medium" :class="step === 2 ? 'text-gray-900' : 'text-gray-400'">Phone</span>
                </div>
                <!-- Line between steps -->
                <div class="flex-1 h-1 bg-gray-300 mx-2 mb-5"></div>
                <!-- Step 3: Address -->
                <div class="flex flex-col items-center ">
                    <div :class="step === 3 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400'" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-200">
                        <!-- Address Icon -->
                        <i class="fas fa-home text-lg"></i>
                    </div>
                    <span class="mt-2 text-sm font-medium" :class="step === 3 ? 'text-gray-900' : 'text-gray-400'">Address</span>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.profile.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="step" id="current_step" value="{{ old('step', 1) }}">

                <!-- Step 1: About -->
                <div x-show="step === 1" x-cloak>
                    <div class="flex flex-col items-center mb-4">
                        <label class="relative cursor-pointer">
                            <img id="profilePreview" src="{{ old('profile_pictures') ? asset('storage/' . old('profile_pictures')) : asset('images/default-avatar.png') }}" class="w-24 h-24 rounded-lg object-cover mb-2" />
                            <input type="file" name="profile_picture" id="profile_picture" class="hidden" accept="image/*" onchange="document.getElementById('profilePreview').src = window.URL.createObjectURL(this.files[0])">
                            <span class="absolute bottom-2 right-2  text-gray rounded-full p-1">
                                <i class="fas fa-upload"></i>
                            </span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">First Name</label>
                        <input type="text" name="first_name" x-model="first_name" value="{{ old('first_name') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. Michael" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Last Name</label>
                        <input type="text" name="last_name" x-model="last_name" value="{{ old('last_name') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. Tomson" required>
                    </div>
                    <div class="mb-4 flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700">Gender</label>
                            <select name="gender" x-model="gender" class="w-full border rounded px-3 py-2 mt-1" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" x-model="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border rounded px-3 py-2 mt-1" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="setStep(2)" class="px-4 py-2 bg-black text-white rounded" :disabled="!isStep1Valid" :class="!isStep1Valid ? 'opacity-50 cursor-not-allowed' : ''">Next</button>
                    </div>
                </div>

                <!-- Step 2: Phone -->
                <div x-show="step === 2" x-cloak>
                    <div class="mb-4">
                        <label class="block text-gray-700">Phone Number</label>
                        <input type="text" name="phone_number" x-model="phone_number" value="{{ old('phone_number') }}" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. +1234567890" required>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" @click="setStep(1)" class="px-4 py-2 bg-gray-200 rounded">Back</button>
                        <button type="button" @click="setStep(3)" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="!isStep2Valid" :class="!isStep2Valid ? 'opacity-50 cursor-not-allowed' : ''">Next</button>
                    </div>
                </div>

                <!-- Step 3: Address -->
                <div x-show="step === 3" x-cloak>
                    <div class="mb-4">
                        <label class="block text-gray-700">Complete Address</label>
                        <textarea name="address" x-model="address" class="w-full border rounded px-3 py-2 mt-1" placeholder="Eg. 123 Main St, City, Country" required>{{ old('address') }}</textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" @click="setStep(2)" class="px-4 py-2 bg-gray-200 rounded">Back</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="!isStep3Valid" :class="!isStep3Valid ? 'opacity-50 cursor-not-allowed' : ''">Finish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection