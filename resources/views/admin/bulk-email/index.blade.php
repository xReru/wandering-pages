@extends('layouts.admin')

@section('header')
    Send Newsletter Email
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Subscriber Count -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Sending to {{ $subscribers->count() }} subscribers
                        </h3>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.bulk-email.send') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Email Subject</label>
                    <div class="mt-1">
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               value="{{ old('subject') }}"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('subject') border-red-300 @enderror"
                               required>
                    </div>
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Email Message</label>
                    <div class="mt-1">
                        <textarea id="message" 
                                  name="message" 
                                  rows="10" 
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('message') border-red-300 @enderror"
                                  required>{{ old('message') }}</textarea>
                    </div>
                    @error('message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Newsletter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 