@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-[#f3f1fc] py-8">
    <div class="max-w-7xl mx-auto px-2 sm:px-4" x-data="{ tab: 'completed' }" x-cloak>
        <h1 class="text-xl font-sans font-medium mb-2">History</h1>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-6 mb-4 border-b border-gray-400">
            <button @click="tab = 'completed'" :class="tab === 'completed' ? 'bg-purple-300 border-b-2 border-purple-700 font-semibold text-purple-900' : 'bg-transparent text-gray-700'" class="px-4 py-2 focus:outline-none transition-colors rounded-t">Completed</button>
            <button @click="tab = 'cancelled'" :class="tab === 'cancelled' ? 'bg-purple-300 border-b-2 border-purple-700 font-semibold text-purple-900' : 'bg-transparent text-gray-700'" class="px-4 py-2 focus:outline-none transition-colors rounded-t">Cancelled</button>
            <button @click="tab = 'refunded'" :class="tab === 'refunded' ? 'bg-purple-300 border-b-2 border-purple-700 font-semibold text-purple-900' : 'bg-transparent text-gray-700'" class="px-4 py-2 focus:outline-none transition-colors rounded-t">Return/Refund</button>
        </div>
        <div>
            <!-- Completed Tab -->
            <div x-show="tab === 'completed'">
                @include('customers.history-partial', ['orders' => $completedOrders, 'emptyText' => 'No completed orders.'])
            </div>
            <!-- Cancelled Tab -->
            <div x-show="tab === 'cancelled'">
                @include('customers.history-partial', ['orders' => $cancelledOrders, 'emptyText' => 'No cancelled orders.'])
            </div>
            <!-- Refunded Tab -->
            <div x-show="tab === 'refunded'">
                @include('customers.history-partial', ['orders' => $refundedOrders, 'emptyText' => 'No return/refund orders.'])
            </div>
        </div>
    </div>
</div>
@endsection 