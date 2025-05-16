@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-serif font-semibold">Order Details</h1>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'paid') bg-green-100 text-green-800
                    @elseif($order->status === 'shipping') bg-blue-100 text-blue-800
                    @elseif($order->status === 'delivering') bg-purple-100 text-purple-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Order Information</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Transaction No:</span>
                            <span class="font-medium">{{ $order->transaction_no }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-medium">{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping Method:</span>
                            <span class="font-medium">{{ ucfirst($order->shipping_method) }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2">Shipping Information</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium">{{ $order->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Address:</span>
                            <span class="font-medium">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 border-b pb-4">
                            <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" 
                                 alt="{{ $item->book->title }}" 
                                 class="w-20 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $item->book->title }}</h3>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-purple-700 font-medium">${{ number_format($item->price_at_time_of_order, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">${{ number_format($item->price_at_time_of_order * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t pt-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">${{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping Fee:</span>
                        <span class="font-medium">${{ number_format($order->shipping_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold pt-2 border-t">
                        <span>Total:</span>
                        <span class="text-purple-700">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($order->payment_proof)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Payment Proof</h2>
                    <img src="{{ Storage::url($order->payment_proof) }}" 
                         alt="Payment Proof" 
                         class="max-w-xs rounded-lg shadow">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 