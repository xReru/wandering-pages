<head>
    @vite('resources/css/app.css')
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

<div class="min-h-screen w-full flex items-center justify-center px-4 py-12">
    <div class="max-w-5xl w-full overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Book Cover Section -->
            <div class="w-full md:w-1/2 lg:w-2/5 bg-white-900 flex items-center justify-center p-8">
                <div class="relative max-w-xs w-full">
                    <img src="{{ asset('images/a-monsoon-rising.png') }}" alt="Monsoon Rising Book Cover"
                        class="w-full h-auto shadow-xl rounded mx-auto">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-indigo-900/30 to-transparent rounded pointer-events-none">
                    </div>
                </div>
            </div>

            <!-- Book Details Section -->
            <div class="w-full md:w-1/2 lg:w-3/5 p-8 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 book-title">Upcoming Book</h1>
                <p class="text-gray-700 mb-8 leading-relaxed">
                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam
                    est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non
                    numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
                </p>
                <div class="mt-2">
                    <button
                        class="notify-btn bg-[#5440aa] text-white py-2 px-8 rounded transition duration-300 ease-in-out">
                        Notify Me
                    </button>
                </div>
            </div>
        </div>

        <!-- Book Title Banner - Only visible on smaller screens -->
        <div class="md:hidden bg-indigo-900 text-center p-4">
            <h2 class="text-3xl font-bold text-yellow-400 book-title">MONSOON RISING</h2>
            <p class="text-white text-lg mt-1">THEA GUANZON</p>
        </div>
    </div>
</div>