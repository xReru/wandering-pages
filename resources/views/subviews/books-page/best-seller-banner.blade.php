<section class="bg-gray-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-8">Best Sellers</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($bestSellers as $book)
                <div class="bg-white rounded-lg shadow flex flex-col items-center p-4">
                    <a href="/books/{{$book->id}}">
                    <img 
                        src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}" 
                        alt="{{ $book->title }} by {{ $book->author }}" 
                        class="h-48 w-full object-contain mb-4 rounded"
                        onerror="this.src='/api/placeholder/320/480';this.onerror='';"
                    >
                    <div class="w-full flex flex-col flex-1 justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">{{ $book->genre }}</p>
                            <h3 class="text-base font-semibold text-gray-800 leading-tight mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">by {{ $book->author }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-purple-700 font-bold text-lg">${{ number_format($book->price, 2) }}</span>
                            <span class="text-xs text-gray-500">Top Seller</span>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section> 