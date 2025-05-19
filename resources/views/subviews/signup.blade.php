@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
    <div class="flex flex-col md:flex-row w-full min-h-screen">
        <!-- Left: Bookshelf Image -->
        <div class="md:w-1/2 w-full flex items-center justify-center bg-white rounded-r-lg overflow-hidden">
            <img src="{{ asset('images/login-image.png') }}" alt="Bookshelf" class="object-cover w-full h-96 md:h-full">
        </div>
        <!-- Right: Signup Form -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <h2 class="font-['DancingScript'] text-4xl font-cursive font-semibold text-center text-purple-800 mb-2">Sign Up</h2>
                <p class="text-center text-gray-500 mb-6">Justo habitant at augue ac sed proin</p>
                @if ($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-start bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <svg class="w-5 h-5 mr-2 mt-1 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"/></svg>
                        <div class="flex-1">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="{{ route('signup') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 @error('username') border-red-500 @enderror" placeholder="Username" value="{{ old('username') }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror" placeholder="Email" value="{{ old('email') }}">
                        
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror" placeholder="Password">
                        
                    </div>
                    <button type="submit" class="w-full py-2 px-4 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-md shadow focus:outline-none">Sign Up</button>
                </form>
                <p class="mt-4 text-center text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Log in</a></p>
            </div>
        </div>
    </div>
@endsection 