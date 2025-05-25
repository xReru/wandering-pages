<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'w-64' : 'w-13'">
            <div class="p-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold font-['EBGaramond']" x-show="sidebarOpen">Admin Panel</h2>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:text-gray-300 focus:outline-none">
                    <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-home mr-2"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="{{ route('admin.books.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.books.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-book mr-2"></i>
                    <span x-show="sidebarOpen">Inventory Management</span>
                </a>
                <a href="{{ route('admin.books.archived') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.books.archived') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-archive mr-2"></i>
                    <span x-show="sidebarOpen">Archived Books</span>
                </a>
                <a href="{{ route('admin.cms.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.cms.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-cogs mr-2"></i>
                    <span x-show="sidebarOpen">Content Management</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span x-show="sidebarOpen">Orders</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 font-['EBGaramond']">
                        @yield('header')
                    </h1>
                    <form method="POST" action="{{ route('logout') }}" class="inline" id="admin-logout-form">
                        @csrf
                        <button type="button" onclick="confirmAdminLogout()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>

                    <script>
                        function confirmAdminLogout() {
                            Swal.fire({
                                title: 'Logout',
                                text: 'Are you sure you want to logout?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Yes, logout',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('admin-logout-form').submit();
                                }
                            });
                        }
                    </script>
                </div>
            </header>

            <main class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Flash Messages -->
    <div
        x-data="{ show: false, message: '' }"
        x-on:flash.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>

    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html> 