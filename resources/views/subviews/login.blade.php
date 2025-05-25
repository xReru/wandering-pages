@php
    if (Auth::guard('customer')->check()) {
        redirect()->route('dashboard')->send();
    }
@endphp
@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row w-full min-h-screen" x-data="{ showForgotPassword: false }">
        <!-- Left: Bookshelf Image -->
        <div class="md:w-1/2 w-full hidden md:flex items-center justify-center bg-white rounded-r-lg overflow-hidden">
            <img src="{{ asset('images/login-image.png') }}" alt="Bookshelf" class="object-cover w-full h-96 md:h-full">
        </div>
        <!-- Right: Login Form -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                @if (session('success'))
                    <div class="mb-4 text-green-600 text-center font-semibold">{{ session('success') }}</div>
                @endif
                <h2 class="font-['DancingScript'] text-6xl font-cursive text-center text-[#1B1146] mb-2">Log
                    in</h2>
                <p class="text-center text-gray-500 mb-6">Justo habitant at augue ac sed proin</p>
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email or Number</label>
                        <input id="email" name="email" type="text" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 py-3 px-4"
                            placeholder="Email or Number">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 py-3 px-4"
                            placeholder="Password">
                        <div class="flex justify-end mt-1">
                            <button type="button" @click="showForgotPassword = true" class="text-sm text-[#7058D3] hover:text-purple-800">Forgot Password?</button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="text-red-500 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <button type="submit"
                        class="w-full py-2 px-4 bg-[#7464B6] hover:bg-[#6354A0] text-white font-semibold rounded-md shadow focus:outline-none">Log
                        in</button>
                </form>
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-2 text-gray-400">or</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <button
                    class="w-full flex items-center justify-center py-2 px-4 mb-2 border border-gray-300 rounded-md bg-white text-gray-700 font-medium cursor-not-allowed"
                    disabled>
                    <i class="fab fa-google w-4 h-4 mr-5"></i>
                    Continue with Google
                </button>
                <button
                    class="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md bg-white text-gray-700 font-medium cursor-not-allowed"
                    disabled>
                    <i class="fab fa-facebook-f w-4 h-4 mr-2"></i>
                    Continue with Facebook
                </button>
                <p class="mt-4 text-center text-sm text-gray-600">Don't have an account? <a href="/signup"
                        class="text-[#7058D3] hover:underline">Sign Up</a></p>
            </div>
        </div>

        <!-- Forgot Password Modal -->
        <div x-show="showForgotPassword"
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-cloak>
            <div class="fixed inset-0 pointer-events-auto" aria-hidden="true">
                <div class="absolute inset-0 w-full h-full backdrop-blur-[1px] bg-transparent"></div>
            </div>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0 relative z-10">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Reset Password
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Enter your email address and we'll send you a link to reset your password.
                                    </p>
                                    <form x-data="{ 
                                        email: '',
                                        message: '',
                                        isSuccess: false,
                                        isError: false,
                                        isLoading: false,
                                        async submitForm() {
                                            this.isLoading = true;
                                            this.message = '';
                                            this.isSuccess = false;
                                            this.isError = false;

                                            // Show SweetAlert loading modal
                                            Swal.fire({
                                                title: 'Sending...',
                                                text: 'Please wait while we send the reset link.',
                                                allowOutsideClick: false,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                }
                                            });

                                            try {
                                                const response = await fetch('{{ route('customer.password.email') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                    },
                                                    body: JSON.stringify({ email: this.email })
                                                });

                                                const data = await response.json();

                                                Swal.close(); // Close the loading modal

                                                if (response.ok) {
                                                    this.isSuccess = true;
                                                    this.message = data.success;
                                                    this.email = '';
                                                    Swal.fire('Success!', data.success, 'success');
                                                    setTimeout(() => showForgotPassword = false, 2000);
                                                } else {
                                                    this.isError = true;
                                                    this.message = data.error || 'An error occurred. Please try again.';
                                                    Swal.fire('Error', this.message, 'error');
                                                }
                                            } catch (error) {
                                                this.isError = true;
                                                this.message = 'An error occurred. Please try again.';
                                                Swal.close();
                                                Swal.fire('Error', this.message, 'error');
                                            } finally {
                                                this.isLoading = false;
                                            }
                                        }
                                    }" @submit.prevent="submitForm" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="reset_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                            <input type="email" x-model="email" id="reset_email" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 py-3 px-4"
                                                placeholder="Enter your email">
                                        </div>
                                        <div x-show="message" 
                                             x-text="message"
                                             :class="{
                                                'text-green-600': isSuccess,
                                                'text-red-600': isError
                                             }"
                                             class="text-sm"></div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                :disabled="isLoading"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm min-w-[120px]">
                                                Send Reset Link
                                            </button>
                                            <button type="button" 
                                                @click="showForgotPassword = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection