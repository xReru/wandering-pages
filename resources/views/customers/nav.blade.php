@extends('layouts.dashboard')

@section('content')
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
                <a href="#" class="flex items-center gap-2 text-red-500 font-medium hover:text-red-700"><i
                        class="fas fa-heart"></i> Likes</a>
                <a href="{{ route('orders.pending') }}"
                    class="flex items-center gap-2 text-blue-600 font-medium hover:text-blue-800"><i
                        class="fas fa-clock"></i> Pending</a>
                <a href="{{ route('orders.shipping') }}"
                    class="flex items-center gap-2 text-orange-500 font-medium hover:text-orange-700"><i
                        class="fas fa-shipping-fast"></i> Shipping</a>
                <a href="{{ route('orders.delivering') }}"
                    class="flex items-center gap-2 text-blue-400 font-medium hover:text-blue-600"><i
                        class="fas fa-truck"></i> Delivering</a>
                <a href="{{ route('orders.ratings') }}"
                    class="flex items-center gap-2 text-yellow-500 font-medium hover:text-yellow-700"><i
                        class="fas fa-star"></i> Ratings</a>
                <a href="#" class="flex items-center gap-2 text-red-400 font-medium hover:text-red-600"><i
                        class="fas fa-history"></i> History</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <section class="flex-1 p-8">
            @yield('content')
        </section>
    </div>
@endsection