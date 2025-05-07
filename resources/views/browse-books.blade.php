@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    @include('subviews.books-page.book-promo-banner', ['books' => $promoBooks])
    @include('subviews.books-page.best-seller-banner')

    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="font-['EBGaramond'] text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-6">Browse All Books</h1>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 bg-gray-100 rounded-lg px-4 py-3">
            <form method="GET" class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <div>
                    <label for="genre" class="block text-xs font-semibold text-gray-700 font-['EBGaramond'] tracking-wide mb-1">GENRE:</label>
                    <select name="genre" id="genre" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 font-['EBGaramond'] text-base">
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" @if($selectedGenre == $genre) selected @endif>{{ $genre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-xs font-semibold text-gray-700 font-['EBGaramond'] tracking-wide mb-1">SORT BY:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 font-['EBGaramond'] text-base">
                        <option value="best_selling" @if($selectedSort == 'best_selling') selected @endif>Best Selling</option>
                        <option value="price_asc" @if($selectedSort == 'price_asc') selected @endif>Price: Low to High</option>
                        <option value="price_desc" @if($selectedSort == 'price_desc') selected @endif>Price: High to Low</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow flex flex-col items-center p-4 transition hover:shadow-lg">
                    <img 
                        src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}" 
                        alt="{{ $book->title }} by {{ $book->author }}" 
                        class="h-48 w-full object-contain mb-4 rounded"
                        onerror="this.src='/api/placeholder/320/480';this.onerror='';"
                    >
                    <div class="w-full flex flex-col flex-1 justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1 font-['EBGaramond']">{{ $book->genre }}</p>
                            <h3 class="text-base font-semibold text-gray-800 leading-tight mb-1 font-['EBGaramond']">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2 font-['EBGaramond']">by {{ $book->author }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-purple-700 font-bold text-lg font-['EBGaramond']">${{ number_format($book->price, 2) }}</span>
                        </div>
                        <div class="flex items-center mt-3 gap-2">
                            <button class="bg-white border border-gray-300 hover:bg-purple-50 text-gray-700 text-xs font-medium py-1 px-3 rounded transition duration-300 font-['EBGaramond'] flex items-center gap-1"><i class="far fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-12 font-['EBGaramond']">No books found.</div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $books->links() }}
        </div>
    </div>
@endsection