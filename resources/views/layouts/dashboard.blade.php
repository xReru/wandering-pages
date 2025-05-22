<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
</head>
@include('subviews.navbar-section')

<style>
    @font-face {
        font-family: 'DancingScript';
        src: url('/fonts/DancingScript-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    @font-face {
        font-family: 'EBGaramond';
        src: url('/fonts/EBGaramond-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    @font-face {
        font-family: 'Heebo-Regular';
        src: url('/fonts/Heebo-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }
</style>

<body class="h-full font-sans antialiased">
    <div class="min-h-screen flex flex-col md:flex-row bg-gradient-to-br from-purple-50 to-white">
        <!-- Sidebar -->
        <aside class="w-full md:w-72 lg:w-80 bg-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-user text-3xl text-white"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-xl font-semibold text-gray-800">Edit Profile</h2>
                        <p class="text-sm text-gray-500">Manage your account</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-6 space-y-2">
                <a href="{{ route('customers.likes') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-heart text-red-500 w-5"></i>
                    <span class="font-medium">Likes</span>
                </a>
                <a href="{{ route('orders.pending') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-clock text-blue-600 w-5"></i>
                    <span class="font-medium">Pending</span>
                </a>
                <a href="{{ route('orders.shipping') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-shipping-fast text-orange-500 w-5"></i>
                    <span class="font-medium">Shipping</span>
                </a>
                <a href="{{ route('orders.delivering') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-truck text-blue-400 w-5"></i>
                    <span class="font-medium">Delivering</span>
                </a>
                <a href="{{ route('orders.completed') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-star text-yellow-500 w-5"></i>
                    <span class="font-medium">Ratings</span>
                </a>
                <a href="{{ route('orders.history') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-history text-red-400 w-5"></i>
                    <span class="font-medium">History</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                @yield('content')
            </div>
        </main>
    </div>

    @include('subviews.footer-section')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html> 