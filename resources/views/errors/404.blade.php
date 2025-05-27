@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4 sm:px-6 md:px-8">
    <img src="{{ asset('images/error.svg') }}" class="w-60 h-45" alt="Error Image">
    <div class="mt-3 flex flex-col items-center max-w-md mx-auto">
        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-6 sm:mb-8">Oops! You are lost</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-4 sm:px-6 py-2 border-b-2 border-[#7464B6] text-[#1B1146] hover:text-[#6354A0] transition font-medium text-sm sm:text-base">
            <span class="mr-2">&#8592;</span> Go Home
        </a>
    </div>
</div>
@endsection 