@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-2 sm:py-4">
    <div class="max-w-3xl mx-auto px-2 sm:px-4">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header Section -->
            <div class="border-b border-gray-100 px-3 py-2 sm:px-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('orders.pending') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-lg sm:text-xl font-serif font-semibold text-gray-800">Order Details</h1>
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium
                        @if($order->status === 'pending') bg-yellow-50 text-yellow-700 border border-yellow-200
                        @elseif($order->status === 'paid') bg-green-50 text-green-700 border border-green-200
                        @elseif($order->status === 'shipping') bg-blue-50 text-blue-700 border border-blue-200
                        @elseif($order->status === 'delivering') bg-purple-50 text-purple-700 border border-purple-200
                        @else bg-red-50 text-red-700 border border-red-200
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Order Information Section -->
            <div class="p-3 sm:p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="bg-gray-50 rounded-md p-3">
                        <h2 class="text-xs font-semibold text-gray-700 mb-2">Order Information</h2>
                        <div class="space-y-1.5 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Transaction No:</span>
                                <span class="font-medium text-gray-900">{{ $order->transaction_no }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Order Date:</span>
                                <span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Payment Method:</span>
                                <span class="font-medium text-gray-900">{{ $order->payment_method }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Shipping Method:</span>
                                <span class="font-medium text-gray-900">{{ ucfirst($order->shipping_method) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-md p-3">
                        <h2 class="text-xs font-semibold text-gray-700 mb-2">Shipping Information</h2>
                        <div class="space-y-1.5 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Name:</span>
                                <span class="font-medium text-gray-900">{{ $order->user->first_name }} {{ $order->user->last_name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Address:</span>
                                <span class="font-medium text-gray-900">{{ $order->shipping_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Section -->
                <div class="mb-4">
                    <h2 class="text-xs font-semibold text-gray-700 mb-2">Order Items</h2>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-md">
                                <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" 
                                     alt="{{ $item->book->title }}" 
                                     class="w-12 h-16 object-cover rounded-md shadow-sm">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 text-sm truncate">{{ $item->book->title }}</h3>
                                    <p class="text-xs text-gray-500">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-xs text-purple-600 font-medium">${{ number_format($item->price_at_time_of_order, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 text-sm">${{ number_format($item->price_at_time_of_order * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="bg-gray-50 rounded-md p-3">
                    <div class="space-y-1.5 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Subtotal:</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Shipping Fee:</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1.5 border-t border-gray-200">
                            <span class="font-semibold text-gray-900">Total:</span>
                            <span class="text-sm font-semibold text-purple-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($order->payment_proof)
                    <div class="mt-4">
                        <h2 class="text-xs font-semibold text-gray-700 mb-1.5">Payment Proof</h2>
                        <div class="bg-gray-50 rounded-md p-2 inline-block">
                            <img src="{{ Storage::url($order->payment_proof) }}" 
                                 alt="Payment Proof" 
                                 class="max-w-[150px] rounded-md shadow-sm">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 