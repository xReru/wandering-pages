@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row w-full min-h-screen">
        <!-- Left: Bookshelf Image -->
        <div class="md:w-1/2 w-full flex items-center justify-center bg-white rounded-r-lg overflow-hidden">
            <img src="{{ asset('images/login-image.png') }}" alt="Bookshelf" class="object-cover w-full h-96 md:h-full">
        </div>
        <!-- Right: Login Form -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                @if (session('success'))
                    <div class="mb-4 text-green-600 text-center font-semibold">{{ session('success') }}</div>
                @endif
                <h2 class="font-['DancingScript'] text-4xl font-cursive font-semibold text-center text-purple-800 mb-2">Log in</h2>
                <p class="text-center text-gray-500 mb-6">Justo habitant at augue ac sed proin</p>
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email or Number</label>
                        <input id="email" name="email" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="Email or Number">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="Password">
                    </div>
                    @if ($errors->any())
                        <div class="text-red-500 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <button type="submit" class="w-full py-2 px-4 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-md shadow focus:outline-none">Log in</button>
                </form>
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-2 text-gray-400">or</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <button class="w-full flex items-center justify-center py-2 px-4 mb-2 border border-gray-300 rounded-md bg-white text-gray-700 font-medium cursor-not-allowed" disabled>
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M21.35 11.1H12.18v2.92h5.32c-.23 1.25-1.4 3.67-5.32 3.67-3.2 0-5.82-2.65-5.82-5.89s2.62-5.89 5.82-5.89c1.82 0 3.04.77 3.74 1.43l2.56-2.49C17.18 4.5 14.92 3.3 12.18 3.3 6.87 3.3 2.5 7.67 2.5 13s4.37 9.7 9.68 9.7c5.6 0 9.32-3.94 9.32-9.5 0-.64-.07-1.13-.15-1.6z"/></svg>
                    Continue with Google
                </button>
                <button class="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md bg-white text-gray-700 font-medium cursor-not-allowed" disabled>
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.6 0 0 .6 0 1.326v21.348C0 23.4.6 24 1.326 24h11.495v-9.294H9.692v-3.622h3.129V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.92.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.4 24 24 23.4 24 22.674V1.326C24 .6 23.4 0 22.675 0"/></svg>
                    Continue with Facebook
                </button>
                <p class="mt-4 text-center text-sm text-gray-600">Don't have an account? <a href="#" class="text-purple-600 hover:underline">Sign Up</a></p>
            </div>
        </div>
    </div>
@endsection