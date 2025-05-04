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
            <!-- Book 1 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('images/draw-down-the-moon.png') }}" alt="Draw Down the Moon"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Dark
                        Fantasy</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Draw Down the Moon</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 2 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('images/modern-divination.png') }}" alt="Modern Divination"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Fantasy
                        Horror</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Modern Divination</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 3 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('images/voice-of-the-ocean.png') }}" alt="Voice of the Ocean"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Fantasy</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Voice of the Ocean</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 4 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{ asset('images/lovely-dark-and-deep.png') }}" alt="Lovely Dark and Deep"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Dark
                        Fantasy</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Lovely Dark and Deep</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Second Row of Books -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
            <!-- Book 5 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{asset('images/this-monster-of-mine.png')}}" alt="This Monster of Mine"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Mystery</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">This Monster of Mine</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 6 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{asset('images/unlock-the-dark.png')}}" alt="Unlock the Dark"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Fantasy</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Unlock the Dark</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 7 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{asset('images/where-the-axe-is-buried.png')}}" alt="Where the Axe is Buried"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Science
                        Fiction</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">Where the Axe is Buried</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Book 8 -->
            <div class="flex flex-col">
                <div class="relative mb-2">
                    <img src="{{asset('images/the-gods-time-forgot.png')}}" alt="The Gods Time Forgot"
                        class="book-cover w-full rounded-md shadow-md">
                    <span
                        class="absolute top-2 left-2 bg-gray-800 bg-opacity-70 text-white text-xs px-2 py-1 rounded">Historical
                        Fiction</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-sm md:text-base">The Gods Time Forgot</h3>
                        <p class="text-gray-600 text-xs md:text-sm">$24.99</p>
                    </div>
                    <button class="heart-icon text-gray-400 hover:text-red-600">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Browse All Books Button -->
        <div class="flex justify-center mt-8">
            <button
                class="browse-btn bg-[#5440aa] hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition duration-300">Browse
                All Books</button>
        </div>
    </section>
</div>