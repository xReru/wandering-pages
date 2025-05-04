<head>@vite('resources/css/app.css')</head>
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="#" class="logo text-gray-800">Wandering Pages</a>
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="#" class="text-gray-700 hover:text-gray-900">Shop</a>
                    <a href="#" class="text-gray-700 hover:text-gray-900">Contact</a>
                </nav>
            </div>

            <!-- Search, Cart and Account -->
            <div class="flex items-center space-x-4">
                <div class="relative w-48 hidden md:block">
                    <input type="text" class="w-full px-4 py-1 border rounded-md" placeholder="Search...">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-800 font-medium mr-1">$30.00</span>
                    <div class="relative">
                        <i class="fas fa-shopping-bag text-gray-700"></i>
                        <span
                            class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">1</span>
                    </div>
                </div>
                <div class="text-gray-700">
                    <i class="fas fa-user-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Hero Section with Book Showcase -->
<section class="hero-section">
    <div class="container mx-auto px-4 py-12">
        <!-- Splide Carousel -->
        <div class="splide" role="group" aria-label="Featured Books">
            <div class="splide__track">
                <ul class="splide__list">
                    <!-- Book 1 -->
                    <li class="splide__slide">
                        <div class="flex book-container items-center justify-between px-8 md:px-16">
                            <!-- Book Information -->
                            <div class="book-info w-full md:w-1/2 pr-0 md:pr-8">
                                <div class="mb-6">
                                    <p class="text-xs uppercase tracking-widest text-indigo-800 font-medium mb-2">NEW
                                        RELEASE</p>
                                    <h1 class="book-title text-5xl md:text-6xl mb-2">Darker by Four</h1>
                                    <p class="book-author text-indigo-800 mb-6">June C.L Tan</p>
                                    <p class="text-gray-700 mb-8 text-sm">
                                        Justo habitant at augue ac sed proin consectetur ac urna nisl elit nulla
                                        facilisis viverra dolor sagittis nisi risus egestas adipiscing nibh euismod.
                                    </p>
                                    <div class="flex space-x-3">
                                        <button
                                            class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 py-2 rounded text-sm font-medium">
                                            Buy Now
                                        </button>
                                        <button
                                            class="bg-white hover:bg-gray-100 text-gray-700 px-5 py-2 rounded text-sm font-medium border border-gray-300">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Book Cover -->
                            <div class="book-cover w-full md:w-1/2 flex justify-center">
                                <img src="{{ asset('images/darker-by-four.png') }}" alt="Darker by Four Book Cover"
                                    class="h-auto max-w-full rounded-lg shadow-lg" width="350" height="500">
                            </div>
                        </div>
                    </li>

                    <!-- Book 2 -->
                    <li class="splide__slide">
                        <div class="flex book-container items-center justify-between px-8 md:px-16">
                            <div class="book-info w-full md:w-1/2 pr-0 md:pr-8">
                                <div class="mb-6">
                                    <p class="text-xs uppercase tracking-widest text-indigo-800 font-medium mb-2">
                                        BESTSELLER</p>
                                    <h1 class="book-title text-5xl md:text-6xl mb-2">The Dark Within Us</h1>
                                    <p class="book-author text-indigo-800 mb-6">Ann Denton</p>
                                    <p class="text-gray-700 mb-8 text-sm">
                                        A captivating mystery set in a coastal town where the past and present collide.
                                        Secrets buried for decades resurface with consequences no one expected.
                                    </p>
                                    <div class="flex space-x-3">
                                        <button
                                            class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 py-2 rounded text-sm font-medium">
                                            Buy Now
                                        </button>
                                        <button
                                            class="bg-white hover:bg-gray-100 text-gray-700 px-5 py-2 rounded text-sm font-medium border border-gray-300">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="book-cover w-full md:w-1/2 flex justify-center">
                                <img src="{{ asset('images/the-dark-within-us.png') }}" alt="Silent Echoes Book Cover"
                                    class="h-auto max-w-full rounded-lg shadow-lg" width="350" height="500">
                            </div>
                        </div>
                    </li>

                    <!-- Book 3 -->
                    <li class="splide__slide">
                        <div class="flex book-container items-center justify-between px-8 md:px-16">
                            <div class="book-info w-full md:w-1/2 pr-0 md:pr-8">
                                <div class="mb-6">
                                    <p class="text-xs uppercase tracking-widest text-indigo-800 font-medium mb-2">COMING
                                        SOON</p>
                                    <h1 class="book-title text-5xl md:text-6xl mb-2">Spin The Dawn</h1>
                                    <p class="book-author text-indigo-800 mb-6">Elizabeth Lim</p>
                                    <p class="text-gray-700 mb-8 text-sm">
                                        In a world where fire is currency and dragons rule the skies, one woman
                                        discovers her destiny as the last fire wielder who can restore balance to the
                                        realm.
                                    </p>
                                    <div class="flex space-x-3">
                                        <button
                                            class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 py-2 rounded text-sm font-medium">
                                            Pre-order
                                        </button>
                                        <button
                                            class="bg-white hover:bg-gray-100 text-gray-700 px-5 py-2 rounded text-sm font-medium border border-gray-300">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="book-cover w-full md:w-1/2 flex justify-center">
                                <img src="{{ asset('images/spin-the-dawn.png') }}" alt="Spin The Dawn Book Cover"
                                    class="h-auto max-w-full rounded-lg shadow-lg" width="350" height="500">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('.splide', {
            type: 'fade',
            perPage: 1,
            perMove: 1,
            gap: '1rem',
            rewind: true,
            pagination: false,
            arrows: true,
            autoplay: true,
            interval: 3000,
            pauseOnHover: true,
            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
            breakpoints: {
                640: {
                    arrows: false,
                }
            }
        }).mount();
    });
</script>