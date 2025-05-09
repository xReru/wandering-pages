@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8 bg-white rounded-lg shadow p-6">
        <div class="flex-shrink-0">
            <img src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}"
                 alt="{{ $book->title }} by {{ $book->author }}"
                 class="h-80 w-56 object-contain rounded mb-4"
                 onerror="this.src='/api/placeholder/320/480';this.onerror='';">
        </div>
        <div class="flex-1 flex flex-col">
            <span class="text-xs text-gray-500 mb-2 font-['EBGaramond']">{{ $book->genre }}</span>
            <h1 class="text-3xl font-bold font-['EBGaramond'] mb-2">{{ $book->title }}</h1>
            <p class="text-lg mb-2 font-['EBGaramond']">Author: <a href="#" class="text-purple-700 hover:underline">{{ $book->author }}</a></p>
            <span class="text-purple-700 font-bold text-2xl mb-4 font-['EBGaramond']">${{ number_format($book->price, 2) }}</span>
            <p class="mb-4 text-gray-700 font-['EBGaramond']">{{ $book->description }}</p>
            <div class="flex items-center gap-2 mb-6">
                <button class="bg-gray-200 px-2 py-1 rounded">-</button>
                <span>1</span>
                <button class="bg-gray-200 px-2 py-1 rounded">+</button>
                <button class="ml-4 bg-purple-700 text-white px-6 py-2 rounded font-bold hover:bg-purple-800 transition">ADD TO CART</button>
            </div>
            <div>
                <span class="text-xs text-gray-500">Category: {{ $book->genre }}</span>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-gray-100 rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 font-['EBGaramond']">Reviews (0)</h2>
        <div class="text-gray-500">No reviews yet.</div>
    </div>
    @include('subviews.book-details.related-books', ['relatedBooks' => $relatedBooks])
</div>
@endsection 