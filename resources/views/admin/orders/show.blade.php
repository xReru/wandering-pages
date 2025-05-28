@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-7xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-serif font-semibold text-gray-900">Order Details</h1>
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-900 transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Orders
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Information</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Transaction No:</span>
                        <span class="font-medium text-gray-900">{{ $order->transaction_no }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Order Date:</span>
                        <span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Payment Method:</span>
                        <span class="font-medium text-gray-900">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Shipping Method:</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($order->shipping_method) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Name:</span>
                        <span class="font-medium text-gray-900">{{ $order->user->full_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Email:</span>
                        <span class="font-medium text-gray-900">{{ $order->user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Phone:</span>
                        <span class="font-medium text-gray-900">{{ $order->user->phone_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Shipping Address:</span>
                        <span class="font-medium text-gray-900">{{ $order->shipping_address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-gray-600 text-sm">Status:</span>
                    <select id="order-status" class="rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm"
                            data-order-id="{{ $order->id }}">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Shipping</option>
                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>Delivering</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button id="update-status-btn" class="px-4 py-2 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Update Status
                    </button>
                    @if($order->status === 'paid')
                        <a href="{{ route('admin.orders.waybill', $order) }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            Print Waybill
                        </a>
                    @endif
                </div>
            </div>

            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" 
                             alt="{{ $item->book->title }}" 
                             class="w-16 h-20 object-cover rounded-md shadow-sm">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-900 truncate">{{ $item->book->title }}</h3>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            <p class="text-sm text-purple-700 font-medium">${{ number_format($item->price_at_time_of_order, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">${{ number_format($item->price_at_time_of_order * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="space-y-2 text-sm max-w-md ml-auto">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Shipping Fee:</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                    <span class="text-base font-semibold text-gray-900">Total:</span>
                    <span class="text-base font-semibold text-purple-700">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        @if($order->payment_proof)
            <div class="p-6 border-t border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Proof</h2>
                <div class="max-w-xs">
                    <img src="{{ Storage::url($order->payment_proof) }}" 
                         alt="Payment Proof" 
                         class="w-full h-auto rounded-lg shadow-sm">
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Simple function to update order status
function updateOrderStatus(orderId, newStatus) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Show loading state
    const button = document.getElementById('update-status-btn');
    button.disabled = true;
    button.innerHTML = 'Updating...';
    
    // Make the API call
    fetch(`/admin/orders/${orderId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Failed to update status');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Failed to update order status'
        });
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = 'Update Status';
    });
}

// Add click event listener when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    const updateButton = document.getElementById('update-status-btn');
    const statusSelect = document.getElementById('order-status');
    
    if (updateButton && statusSelect) {
        updateButton.addEventListener('click', function() {
            const orderId = statusSelect.dataset.orderId;
            const newStatus = statusSelect.value;
            updateOrderStatus(orderId, newStatus);
        });
    }
});
</script>
@endpush
@endsection 