@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-serif font-semibold text-gray-800">Delivering Orders</h1>
            <a href="/browse-books" class="hidden sm:inline-block px-4 py-2 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 transition-colors duration-200">
                Browse Books
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 text-center">
                <p class="text-gray-500 text-sm sm:text-base">You have no delivering orders.</p>
                <a href="/browse-books" class="inline-block mt-3 px-4 py-2 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 transition-colors duration-200 sm:hidden">Browse Books</a>
            </div>
        @else
            <div class="grid gap-3 sm:gap-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-4 sm:p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-3">
                                <div class="space-y-1">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">Order #{{ $order->transaction_no }}</h2>
                                    <p class="text-xs sm:text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <span class="self-start sm:self-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    Delivering
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-3">
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-500">Payment Method</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $order->payment_method }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-500">Shipping Method</p>
                                    <p class="text-sm font-medium text-gray-700">{{ ucfirst($order->shipping_method) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-500">Total Amount</p>
                                    <p class="text-sm font-medium text-gray-700">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-500">Items</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $order->items->sum('quantity') }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('orders.show', $order) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-purple-700 bg-purple-50 rounded-md hover:bg-purple-100 transition-colors duration-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 