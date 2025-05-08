<head>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .book-cover {
            transition: all 0.8s ease;
            transform-origin: center bottom;
        }

        .book-cover-container {
            perspective: 1000px;
        }
    </style>
</head>
<div class="container mx-auto px-4 py-12 max-w-6xl">
    <!-- Books Section -->
    <section class="p-6 md:p-8">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">More Books</h2>

        <!-- First Row of Books -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
            @foreach($books->take(4) as $book)
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">{{ $book->genre }}</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">{{ $book->title }}</h3>
                        <p class="text-gray-600 text-xs md:text-sm">${{ number_format($book->price, 2) }}</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Second Row of Books -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
            @foreach($books->skip(4)->take(4) as $book)
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">{{ $book->genre }}</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">{{ $book->title }}</h3>
                        <p class="text-gray-600 text-xs md:text-sm">${{ number_format($book->price, 2) }}</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Browse All Books Button -->
        <div class="flex justify-center mt-8">
            <a href="/browse-books"
                class="browse-btn bg-[#5440aa] hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition duration-300">Browse
                All Books</a>
        </div>
    </section>
</div>