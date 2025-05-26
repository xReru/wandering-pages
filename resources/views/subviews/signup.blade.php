@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add Flash Message Handler -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#9333ea'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonColor: '#9333ea'
        });
    </script>
    @endif

    <div class="flex flex-col md:flex-row w-full min-h-screen">
        <!-- Left: Bookshelf Image -->
        <div class="md:w-1/2 w-full hidden md:flex items-center justify-center bg-white rounded-r-lg overflow-hidden">
            <img src="{{ asset('images/login-image.png') }}" alt="Bookshelf" class="object-cover w-full h-96 md:h-full">
        </div>
        <!-- Right: Signup Form -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <h2 class="font-['DancingScript'] text-6xl font-cursive text-center text-[#1B1146] mb-2">Sign Up</h2>
                <p class="text-center text-gray-500 mb-12">Justo habitant at augue ac sed proin</p>
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
                <form action="{{ route('signup') }}" method="POST" class="space-y-4" id="signupForm">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" required
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7464B6] focus:ring focus:ring-[#7464B6] focus:ring-opacity-50 py-3 px-4 @error('username') border-red-500 @enderror"
    placeholder="Username" value="{{ old('username') }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7464B6] focus:ring focus:ring-[#7464B6] focus:ring-opacity-50 py-3 px-4 @error('email') border-red-500 @enderror"
    placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7464B6] focus:ring focus:ring-[#7464B6] focus:ring-opacity-50 py-3 px-4 @error('password') border-red-500 @enderror"
    placeholder="Password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7464B6] focus:ring focus:ring-[#7464B6] focus:ring-opacity-50 py-3 px-4 @error('password_confirmation') border-red-500 @enderror"
    placeholder="Confirm Password">
                    </div>
                    <button type="submit" class="w-full py-2 px-4 bg-[#7464B6] hover:bg-[#6354A0] text-white font-semibold rounded-md shadow focus:outline-none">Sign Up</button>
                </form>
                <p class="mt-4 text-center text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-[#7058D3] hover:underline">Log in</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if passwords match
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'The passwords do not match. Please try again.',
                    confirmButtonColor: '#9333ea'
                });
                return;
            }
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    const data = await response.json();
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                } else {
                    // If the response is not JSON, it's a redirect response
                    const redirectUrl = response.url;
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Account created successfully. Please log in.',
                        confirmButtonColor: '#9333ea'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = redirectUrl;
                        }
                    });
                    return;
                }
            })
            .catch(error => {
                let errorMessage = 'An error occurred while processing your request.';
                
                if (error.errors) {
                    // Handle validation errors
                    const errorMessages = Object.values(error.errors).flat();
                    errorMessage = errorMessages.join('\n');
                } else if (error.message) {
                    errorMessage = error.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                    confirmButtonColor: '#9333ea'
                });
            });
        });
    </script>
@endsection