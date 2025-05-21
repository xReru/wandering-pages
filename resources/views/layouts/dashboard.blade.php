<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
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
<body class="h-full">
    <div class="flex flex-col md:flex-row min-h-screen bg-purple-50">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white shadow-md p-6 flex-shrink-0">
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-purple-200 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-user text-3xl text-purple-600"></i>
                </div>
                <span class="font-semibold text-gray-700">Edit Profile</span>
            </div>
            <nav class="flex flex-col gap-4">
                <a href="{{ route('customers.likes') }}" class="flex items-center gap-2 text-red-500 font-medium hover:text-red-700"><i class="fas fa-heart"></i> Likes</a>
                <a href="{{ route('orders.pending') }}" class="flex items-center gap-2 text-blue-600 font-medium hover:text-blue-800"><i class="fas fa-clock"></i> Pending</a>
                <a href="{{ route('orders.shipping') }}" class="flex items-center gap-2 text-orange-500 font-medium hover:text-orange-700"><i class="fas fa-shipping-fast"></i> Shipping</a>
                <a href="{{ route('orders.delivering') }}" class="flex items-center gap-2 text-blue-400 font-medium hover:text-blue-600"><i class="fas fa-truck"></i> Delivering</a>
                <a href="{{ route('orders.completed') }}" class="flex items-center gap-2 text-yellow-500 font-medium hover:text-yellow-700"><i class="fas fa-star"></i> Ratings</a>
                <a href="{{ route('orders.history') }}" class="flex items-center gap-2 text-red-400 font-medium hover:text-red-600"><i class="fas fa-history"></i> History</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @include('subviews.footer-section')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html> 