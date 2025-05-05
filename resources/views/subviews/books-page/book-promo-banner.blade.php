<head>@vite('resources/css/app.css')</head>
@props([
    'title' => 'Buy the Complete Series for less',
    'originalPrice' => 73.50,
    'salePrice' => 43.50,
    'books' => [
        [
            'title' => 'Before Darkest Hour',
            'author' => 'Brenna Harlow',
            'image' => '/images/books/before-darkest-hour.jpg',
            'rotate' => '-rotate-3'
        ],
        [
            'title' => 'Dark Sky',
            'author' => 'Brenna Harlow',
            'image' => '/images/books/dark-sky.jpg',
            'rotate' => 'rotate-3'
        ],
        [
            'title' => 'After Dawn',
            'author' => 'Brenna Harlow',
            'image' => '/images/books/after-dawn.jpg',
            'rotate' => '-rotate-3'
        ],
        [
            'title' => 'Shadows Rise',
            'author' => 'Brenna Harlow',
            'image' => '/images/books/shadows-rise.jpg',
            'rotate' => 'rotate-3'
        ],
    ],
    'buyNowUrl' => '#',
    'browseMoreUrl' => '#'
])

<section class="bg-purple-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between bg-purple-300 rounded-lg overflow-hidden">
            <!-- Left Section with Text and CTA -->
            <div class="p-6 md:p-8 lg:p-12 md:w-1/2 lg:w-2/5">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-purple-900 mb-4">{{ $title }}</h2>
                
                <div class="flex items-center mb-6">
                    <p class="text-gray-500 line-through mr-3 text-lg">${{ number_format($originalPrice, 2) }}</p>
                    <p class="text-purple-900 font-bold text-xl sm:text-2xl">${{ number_format($salePrice, 2) }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ $buyNowUrl }}" class="bg-purple-700 hover:bg-purple-800 text-white font-medium py-2 px-6 rounded transition duration-300 text-center">Buy Now</a>
                    <a href="{{ $browseMoreUrl }}" class="border border-purple-400 hover:border-purple-600 text-purple-700 font-medium py-2 px-6 rounded transition duration-300 text-center">Browse More</a>
                </div>
            </div>
            
            <!-- Right Section with Book Covers -->
            <div class="p-4 md:w-1/2 lg:w-3/5 relative">
                <div class="relative h-64 sm:h-72 md:h-80 lg:h-96">
                    @foreach($books as $index => $book)
                        <div class="absolute {{ $index === 0 ? 'left-0' : ($index === 1 ? 'left-1/4' : ($index === 2 ? 'left-1/2' : 'left-2/3')) }} w-2/3 h-full z-{{ 40 - ($index * 10) }} transform {{ $book['rotate'] }} hover:rotate-0 hover:scale-105 transition-transform duration-300">
                            <img 
                                src="{{ asset($book['image']) }}" 
                                alt="{{ $book['title'] }} by {{ $book['author'] }}" 
                                class="h-full w-full object-cover shadow-xl rounded"
                                onerror="this.src='/api/placeholder/320/480';this.onerror='';"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>