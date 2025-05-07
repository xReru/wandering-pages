@props([
    'title' => 'Best Sellers',
    'books' => [
        [
            'title' => 'Draw Down the Moon',
            'author' => 'Kristin Cast',
            'genre' => 'Fantasy',
            'image' => '/images/draw-down-the-moon.png',
            'price' => 24.00
        ],
        // Add more books as needed
    ]
])

<section class="bg-gray-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-8">{{ $title }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow flex flex-col items-center p-4">
                    <img 
                        src="{{ asset($book['image']) }}" 
                        alt="{{ $book['title'] }} by {{ $book['author'] }}" 
                        class="h-48 w-full object-contain mb-4 rounded"
                        onerror="this.src='/api/placeholder/320/480';this.onerror='';"
                    >
                    <div class="w-full flex flex-col flex-1 justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">{{ $book['genre'] }}</p>
                            <h3 class="text-base font-semibold text-gray-800 leading-tight mb-1">{{ $book['title'] }}</h3>
                            <p class="text-sm text-gray-600 mb-2">by {{ $book['author'] }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-purple-700 font-bold text-lg">${{ number_format($book['price'], 2) }}</span>
                        </div>
                        <div class="flex items-center mt-3 gap-2">
                            <div x-data="{ qty: 1 }" class="flex items-center border rounded px-2 py-1">
                                <button class="text-gray-500 focus:outline-none" type="button" @click="if(qty > 1) qty--">-</button>
                                <input type="text" :value="qty" readonly class="w-8 text-center border-0 focus:ring-0 bg-transparent appearance-none" style="appearance: none; -moz-appearance: textfield;" />
                                <button class="text-gray-500 focus:outline-none" type="button" @click="qty++">+</button>
                            </div>
                            <button class="bg-purple-700 hover:bg-purple-800 text-white text-xs font-medium py-2 px-4 rounded transition duration-300">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section> 