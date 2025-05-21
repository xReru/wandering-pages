@extends('layouts.dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-2xl font-serif font-semibold mb-6">Pending Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">You have no pending orders.</p>
            <a href="/browse-books" class="inline-block mt-4 px-6 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Browse Books</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-semibold">Order #{{ $order->transaction_no }}</h2>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'paid') bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($order->status) }}
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
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">View Details</a>
                        @if(in_array($order->status, ['pending', 'paid']))
                            <button type="button" onclick="confirmCancel('{{ $order->id }}')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Cancel Order</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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