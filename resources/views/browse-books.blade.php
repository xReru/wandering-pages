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
            <div x-data="{ 
                genre: '{{ $selectedGenre ?? 'all' }}',
                sort: '{{ $selectedSort ?? '' }}',
                loading: false,
                async updateFilters() {
                    console.log('Updating filters...', { genre: this.genre, sort: this.sort });
                    this.loading = true;
                    
                    try {
                        const url = `/api/filtered-books?genre=${encodeURIComponent(this.genre)}&sort=${encodeURIComponent(this.sort)}`;
                        console.log('Fetching from:', url);
                        
                        const response = await fetch(url);
                        console.log('Response status:', response.status);
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        const data = await response.json();
                        console.log('Received data:', data);
                        
                        const booksGrid = document.getElementById('books-grid');
                        if (booksGrid) {
                            booksGrid.innerHTML = data.html;
                            console.log('Updated books grid');
                        } else {
                            console.error('Books grid element not found');
                        }
                    } catch (error) {
                        console.error('Error updating filters:', error);
                    } finally {
                        this.loading = false;
                        console.log('Loading state set to false');
                    }
                }
            }" 
            x-init="console.log('Alpine.js initialized'); $watch('genre', value => { console.log('Genre changed:', value); updateFilters(); }); $watch('sort', value => { console.log('Sort changed:', value); updateFilters(); })" 
            class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <div>
                    <label for="genre" class="block text-xs font-semibold text-gray-700 font-['EBGaramond'] tracking-wide mb-1">GENRE:</label>
                    <select name="genre" id="genre" x-model="genre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 font-['EBGaramond'] text-base">
                        <option value="all" @if($selectedGenre == 'all') selected @endif>All</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" @if($selectedGenre == $genre) selected @endif>{{ $genre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-xs font-semibold text-gray-700 font-['EBGaramond'] tracking-wide mb-1">SORT BY:</label>
                    <select name="sort" id="sort" x-model="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 font-['EBGaramond'] text-base">
                        <option value="">Default</option>
                        <option value="best_selling" @if($selectedSort == 'best_selling') selected @endif>Best Selling</option>
                        <option value="price_asc" @if($selectedSort == 'price_asc') selected @endif>Price: Low to High</option>
                        <option value="price_desc" @if($selectedSort == 'price_desc') selected @endif>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="relative">
            <div x-show="loading" x-cloak class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-700"></div>
            </div>
            <div id="books-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @include('subviews.books-page.book-grid', ['books' => $books])
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
@endsection