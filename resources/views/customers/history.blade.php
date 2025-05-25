@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'completed' }" x-cloak>
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-sans font-semibold text-gray-800">Order History</h1>
            <p class="mt-1 text-sm text-gray-600">View your completed and cancelled orders</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mb-6 border-b border-gray-200">
            <button @click="tab = 'completed'" 
                :class="tab === 'completed' ? 'bg-[#F9F8FF] border-b-2 border-[#7464B6] font-medium text-[#7464B6]' : 'bg-transparent text-gray-600 hover:text-[#7464B6]'" 
                class="text-[#7464B6] px-4 py-2.5 focus:outline-none transition-all duration-200 rounded-t-lg text-sm sm:text-base">
                Completed Orders
            </button>
            <button @click="tab = 'cancelled'" 
                :class="tab === 'cancelled' ? 'bg-[#F9F8FF] border-b-2 border-[#7464B6] font-medium text-[#7464B6]' : 'bg-transparent text-gray-600 hover:text-[#7464B6]'" 
                class="text-[#7464B6] px-4 py-2.5 focus:outline-none transition-all duration-200 rounded-t-lg text-sm sm:text-base">
                Cancelled Orders
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <!-- Completed Tab -->
            <div x-show="tab === 'completed'" class="p-4 sm:p-6">
                @include('customers.history-partial', ['orders' => $completedOrders, 'emptyText' => 'No completed orders found.'])
            </div>
            <!-- Cancelled Tab -->
            <div x-show="tab === 'cancelled'" class="p-4 sm:p-6">
                @include('customers.history-partial', ['orders' => $cancelledOrders, 'emptyText' => 'No cancelled orders found.'])
            </div>
        </div>
    </div>
</div>
@endsection 