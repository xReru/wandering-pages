@extends('layouts.admin')
@section('header')
    Order Management System
@endsection
@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Bulk Actions -->
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <form id="bulk-action-form" action="{{ route('admin.orders.bulk-update') }}" method="POST" class="flex items-center space-x-4">
                @csrf
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="select-all" class="text-sm text-gray-700">Select All</label>
                </div>
                <select name="status" id="bulk-status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Bulk Actions</option>
                    <option value="pending">Mark as Pending</option>
                    <option value="paid">Mark as Paid</option>
                    <option value="shipping">Mark as Shipping</option>
                    <option value="delivering">Mark as Delivering</option>
                    <option value="completed">Mark as Completed</option>
                    <option value="cancelled">Mark as Cancelled</option>
                </select>
                <button type="submit" id="bulk-update-btn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Update Selected
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected_orders[]" value="{{ $order->id }}" class="order-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->transaction_no }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->user->full_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'paid') bg-green-100 text-green-800
                                @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                @elseif($order->status === 'delivered') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-purple-600 hover:text-purple-900">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                </div>
                <div class="flex space-x-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkStatusSelect = document.getElementById('bulk-status');
    const bulkUpdateBtn = document.getElementById('bulk-update-btn');
    const bulkActionForm = document.getElementById('bulk-action-form');

    // Handle select all checkbox
    selectAllCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkUpdateButton();
    });

    // Handle individual checkboxes
    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkUpdateButton();
            // Update select all checkbox state
            selectAllCheckbox.checked = Array.from(orderCheckboxes).every(cb => cb.checked);
        });
    });

    // Handle bulk status select
    bulkStatusSelect.addEventListener('change', updateBulkUpdateButton);

    // Update bulk update button state
    function updateBulkUpdateButton() {
        const hasSelectedOrders = Array.from(orderCheckboxes).some(cb => cb.checked);
        const hasSelectedStatus = bulkStatusSelect.value !== '';
        bulkUpdateBtn.disabled = !(hasSelectedOrders && hasSelectedStatus);
    }

    // Handle form submission
    bulkActionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedOrders = Array.from(orderCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        if (selectedOrders.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'No Orders Selected',
                text: 'Please select at least one order to update.'
            });
            return;
        }

        if (!bulkStatusSelect.value) {
            Swal.fire({
                icon: 'error',
                title: 'No Status Selected',
                text: 'Please select a status to update the orders to.'
            });
            return;
        }

        // Create hidden input for selected orders
        const selectedOrdersInput = document.createElement('input');
        selectedOrdersInput.type = 'hidden';
        selectedOrdersInput.name = 'selected_orders';
        selectedOrdersInput.value = JSON.stringify(selectedOrders);
        this.appendChild(selectedOrdersInput);

        // Show confirmation dialog
        Swal.fire({
            title: 'Update Order Statuses?',
            text: `Are you sure you want to update ${selectedOrders.length} order(s) to "${bulkStatusSelect.options[bulkStatusSelect.selectedIndex].text}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, update them!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection 