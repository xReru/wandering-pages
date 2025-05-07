<head>@vite('resources/css/app.css')</head>
@props([
    'title' => 'Buy the Complete Series for less',
    'originalPrice' => 73.50,
    'salePrice' => 43.50,
    'books' => [
        [
            'title' => 'Before the Darkest Hour',
            'author' => 'Brenna Harlow',
            'image' => '/images/before-the-darkest-hour.png',
            'rotate' => '-rotate-0'
        ],
        [
            'title' => 'Blood at Dusk',
            'author' => 'Brenna Harlow',
            'image' => '/images/blood-at-dusk.png',
            'rotate' => 'rotate-0'
        ],
        [
            'title' => 'Blood After Dawn',
            'author' => 'Brenna Harlow',
            'image' => '/images/blood-after-dawn.png',
            'rotate' => '-rotate-0'
        ],
        [
            'title' => 'Blood follows Midnight',
            'author' => 'Brenna Harlow',
            'image' => '/images/blood-follows-midnight.png',
            'rotate' => 'rotate-0'
        ],
        [
            'title' => 'Blood before Sunrise',
            'author' => 'Brenna Harlow',
            'image' => '/images/blood-before-sunrise.png',
            'rotate' => 'rotate-0'
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
                        @php
                        $leftClass = match($index) {
                            0 => 'left-0',
                            1 => 'left-[15%]',
                            2 => 'left-[30%]',
                            3 => 'left-[45%]',
                            4 => 'left-[60%]',
                            default => 'left-0',
                        };
                        @endphp
                        <div class="absolute {{ $leftClass }} w-1/2 h-full z-{{ 50 - ($index * 10) }} transform {{ $book['rotate'] }} hover:rotate-0 hover:scale-110 transition-all duration-300">
                            <img 
                                src="{{ asset($book['image']) }}" 
                                alt="{{ $book['title'] }} by {{ $book['author'] }}" 
                                class="h-full w-full object-contain shadow-xl rounded"
                                onerror="this.src='/api/placeholder/320/480';this.onerror='';"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>