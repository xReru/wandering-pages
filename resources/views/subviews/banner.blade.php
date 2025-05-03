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
        <div class="relative">
            <!-- Carousel Controls -->
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 carousel-control">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 carousel-control">
                <i class="fas fa-chevron-right"></i>
            </div>

            <!-- Book Container -->
            <div class="flex book-container items-center justify-between px-8 md:px-16">
                <!-- Book Information -->
                <div class="book-info w-full md:w-1/2 pr-0 md:pr-8">
                    <div class="mb-6">
                        <p class="text-xs uppercase tracking-widest text-indigo-800 font-medium mb-2">NEW RELEASE
                        </p>
                        <h1 class="book-title text-5xl md:text-6xl mb-2">Darker by Four</h1>
                        <p class="text-gray-600 mb-6">June C.L Tan</p>
                        <p class="text-gray-700 mb-8 text-sm">
                            Justo habitant at augue ac sed proin consectetur ac urna nisl elit nulla facilisis
                            viverra dolor sagittis nisi risus egestas adipiscing nibh euismod.
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
                    <img src="/api/placeholder/350/550" alt="Darker by Four Book Cover"
                        class="h-auto max-w-full rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // This would be implemented with proper carousel functionality in a real application
    document.addEventListener('DOMContentLoaded', function () {
        const prevButton = document.querySelector('.carousel-control:first-child');
        const nextButton = document.querySelector('.carousel-control:last-child');

        // Add event listeners for carousel navigation
        prevButton.addEventListener('click', () => {
            console.log('Previous book');
        });

        nextButton.addEventListener('click', () => {
            console.log('Next book');
        });
    });
</script>