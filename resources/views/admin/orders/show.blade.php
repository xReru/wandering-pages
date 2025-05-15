@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-semibold">Order Details</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-purple-600 hover:text-purple-900">← Back to Orders</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h2 class="text-lg font-semibold mb-4">Order Information</h2>
                <div class="space-y-2">
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
                <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Name:</span>
                        <span class="font-medium">{{ $order->user->full_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium">{{ $order->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phone:</span>
                        <span class="font-medium">{{ $order->user->phone_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping Address:</span>
                        <span class="font-medium">{{ $order->shipping_address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Order Items</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Status:</span>
                    <select id="order-status" class="rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                            data-order-id="{{ $order->id }}">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button id="update-status-btn" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Update Status
                    </button>
                    @if($order->status === 'paid')
                        <a href="{{ route('admin.orders.waybill', $order) }}" 
                           target="_blank"
                           class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Print Waybill</span>
                        </a>
                    @endif
                </div>
            </div>

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