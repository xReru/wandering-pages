<head>@vite('resources/css/app.css')</head>
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="#" class="logo text-gray-800">Wandering Pages</a>
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="#" class="text-gray-700 hover:text-gray-900">Shop</a>
                    <a href="/contact-us" class="text-gray-700 hover:text-gray-900">Contact</a>
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