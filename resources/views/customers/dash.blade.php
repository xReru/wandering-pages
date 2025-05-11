@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Customer Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-medium mb-2">Profile Information</h2>
                <p class="text-gray-600">
                    <strong>Name:</strong> {{ Auth::user()->name }}
                </p>
                <p class="text-gray-600">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                </p>
                <p class="text-gray-600">
                    <strong>Phone:</strong> {{ Auth::user()->phone }}
                </p>
                <p class="text-gray-600">
                    <strong>Address:</strong> {{ Auth::user()->address }}
                </p>
            </div>
        </div>
    </div>
@endsection


