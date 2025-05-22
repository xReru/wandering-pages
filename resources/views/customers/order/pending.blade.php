@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6 py-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-4 sm:px-5">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-serif font-bold text-gray-900">Pending Orders</h1>
                <a href="/browse-books" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                    Browse Books
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-1 text-base font-medium text-gray-900">No pending orders</h3>
                    <p class="mt-0.5 text-sm text-gray-500">Start shopping to see your orders here.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="p-4">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-3">
                                    <div class="space-y-0.5">
                                        <h2 class="text-lg font-semibold text-gray-900">Order #{{ $order->transaction_no }}</h2>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'paid') bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="h-4 w-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            <span>Payment Method: <span class="font-medium text-gray-900">{{ $order->payment_method }}</span></span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="h-4 w-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                            </svg>
                                            <span>Shipping Method: <span class="font-medium text-gray-900">{{ ucfirst($order->shipping_method) }}</span></span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="h-4 w-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Total Amount: <span class="font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</span></span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="h-4 w-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span>Items: <span class="font-medium text-gray-900">{{ $order->items->sum('quantity') }}</span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row justify-end gap-2">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                    @if(in_array($order->status, ['pending', 'paid']))
                                        <button type="button" 
                                                onclick="confirmCancel('{{ $order->id }}')" 
                                                class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancel Order
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.confirmCancel = function(orderId) {
        Swal.fire({
            title: 'Cancel Order',
            text: "Are you sure you want to cancel this order? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send cancel request
                fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Cancelled!',
                            'Your order has been cancelled.',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message || 'Something went wrong.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                });
            }
        });
    };
});
</script>
@endpush 