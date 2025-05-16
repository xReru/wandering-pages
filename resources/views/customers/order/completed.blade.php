@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-serif font-semibold mb-6">Completed Orders</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">You have no completed orders.</p>
                <a href="/browse-books" class="inline-block mt-4 px-6 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Browse Books</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h2 class="text-lg font-semibold">Order #{{ $order->transaction_no }}</h2>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                Completed
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Payment Method: <span class="font-medium">{{ $order->payment_method }}</span></p>
                                <p class="text-sm text-gray-600">Shipping Method: <span class="font-medium">{{ ucfirst($order->shipping_method) }}</span></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Amount: <span class="font-medium">${{ number_format($order->total_amount, 2) }}</span></p>
                                <p class="text-sm text-gray-600">Items: <span class="font-medium">{{ $order->items->sum('quantity') }}</span></p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 