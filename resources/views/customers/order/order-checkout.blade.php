@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $orderInfo = Str::random(10);
    $transactionNo = random_int(1000000000000000, 9999999999999999);
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="flex flex-col lg:flex-row" x-data="checkout">
                <!-- Left: Shipping & Payment -->
                <div class="w-full lg:flex-1 p-6 lg:p-8 border-b lg:border-b-0 lg:border-r border-gray-200">
                    <div class="max-w-2xl mx-auto">
                        <h2 class="text-2xl font-serif font-semibold mb-6 text-gray-900">Checkout</h2>
                        
                        <!-- Shipping Information Card -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#7464B6]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Shipping Information
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-[#7464B6]">Full Name:</span>
                                    <span class="text-gray-800">{{ $user->name ?? $user->username }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-[#7464B6]">Phone:</span>
                                    <span class="text-gray-800">{{ $user->phone_number ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-[#7464B6]">Address:</span>
                                    <span class="text-gray-800">{{ $user->address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Card -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#7464B6]" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                </svg>
                                Payment Method
                            </h3>
                            <form id="payment-form" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="relative flex items-center p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="paymentMethod === 'Apple Pay' ? 'border-[#6354A0] bg-purple-50' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="payment_method" value="Apple Pay" class="sr-only" @change="paymentMethod = 'Apple Pay'">
                                        <div class="flex items-center">
                                            <img src="{{ asset('images/apple_pay.png') }}" alt="Apple Pay" class="h-8 w-10 mr-3">
                                            <span class="text-sm font-medium text-gray-900">Apple Pay</span>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="paymentMethod === 'Google Pay' ? 'border-[#6354A0] bg-[#6354A0]' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="payment_method" value="Google Pay" class="sr-only" @change="paymentMethod = 'Google Pay'">
                                        <div class="flex items-center">
                                            <img src="{{ asset('images/google_pay.png') }}" alt="Google Pay" class="h-8 w-10 mr-3">
                                            <span class="text-sm font-medium text-gray-900">Google Pay</span>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="paymentMethod === 'GCash' ? 'border-[#6354A0] bg-[#6354A0]' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="payment_method" value="GCash" class="sr-only" checked @change="paymentMethod = 'GCash'">
                                        <div class="flex items-center">
                                            <img src="{{ asset('images/gcash.png') }}" alt="GCash" class="h-8 w-10 mr-3">
                                            <span class="text-sm font-medium text-gray-900">GCash</span>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="paymentMethod === 'Paypal' ? 'border-[#6354A0] bg-[#6354A0]' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="payment_method" value="Paypal" class="sr-only" @change="paymentMethod = 'Paypal'">
                                        <div class="flex items-center">
                                            <img src="{{ asset('images/paypal.png') }}" alt="Paypal" class="h-8 w-10 mr-3">
                                            <span class="text-sm font-medium text-gray-900">Paypal</span>
                                        </div>
                                    </label>
                                </div>
                            </form>
                        </div>

                        <!-- Shipping Method Card -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#7464B6]" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-2-2A1 1 0 0017 4H3z" />
                                </svg>
                                Shipping Method
                            </h3>
                            <form id="shipping-method-form" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="relative flex items-start p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="shippingMethod === 'standard' ? 'border-[#6354A0] bg-[#6354A0]' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="shipping_method" value="standard" class="sr-only" checked @change="updateShipping('standard')">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-[#7464B6]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-gray-900">Standard Shipping</span>
                                                    <span class="block text-xs text-gray-500 mt-1">5-7 days delivery</span>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm font-medium text-[#7464B6]">$20.00</div>
                                        </div>
                                    </label>
                                    <label class="relative flex items-start p-4 bg-white rounded-lg border-2 cursor-pointer transition"
                                           :class="shippingMethod === 'express' ? 'border-[#6354A0] bg-[#6354A0]' : 'border-gray-200 hover:border-[#6354A0]'">
                                        <input type="radio" name="shipping_method" value="express" class="sr-only" @change="updateShipping('express')">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-[#7464B6]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-gray-900">Express Shipping</span>
                                                    <span class="block text-xs text-gray-500 mt-1">2-5 days delivery</span>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm font-medium text-[#7464B6]">$50.00</div>
                                        </div>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="w-full lg:w-[420px] bg-purple-50 p-6 lg:p-8">
                    <div class="sticky top-8">
                        <h2 class="text-2xl font-serif font-semibold mb-6 text-gray-900">Order Summary</h2>
                        
                        <!-- Order Items -->
                        <div class="space-y-6 mb-8">
                            <template x-if="selectedItems.length > 0">
                                <div class="space-y-4">
                                    <template x-for="item in selectedItems" :key="item.id">
                                        <div class="flex items-start space-x-4 bg-white p-4 rounded-lg shadow-sm">
                                            <img :src="item.book.image_url" :alt="item.book.title" class="h-24 w-20 object-cover rounded-lg shadow">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate" x-text="item.book.title"></h4>
                                                <p class="text-sm text-gray-500 mt-1" x-text="item.quantity + 'x'"></p>
                                                <p class="text-sm font-medium text-[#7464B6] mt-2" x-text="'$' + (item.book.price * item.quantity).toFixed(2)"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="selectedItems.length === 0">
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No items selected</h3>
                                    <p class="mt-1 text-sm text-gray-500">Add items to your cart to proceed with checkout.</p>
                                </div>
                            </template>
                        </div>

                        <!-- Price Summary -->
                        <div class="bg-white rounded-lg p-6 shadow-sm mb-6">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900" x-text="'$' + subtotal.toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-gray-900" x-text="'$' + shippingFee.toFixed(2)"></span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span class="text-base font-medium text-[#7464B6]" x-text="'$' + total.toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-6">
                            <form class="flex space-x-2">
                                <input type="text" placeholder="Enter promo code" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6354A0] focus:border-[#6354A0] text-sm">
                                <button type="button" class="px-4 py-2 bg-purple-100 text-[#7464B6] rounded-lg hover:bg-purple-200 transition-colors text-sm font-medium">Apply</button>
                            </form>
                            <p class="mt-2 text-xs text-gray-500">Enter your promo code to get special discounts</p>
                        </div>

                        <!-- Place Order Button -->
                        <div x-data="{ showModal: false }">
                            <button @click="showModal = true" class="w-full bg-[#7464B6] text-white py-3 px-4 rounded-lg font-medium hover:bg-[#6354A0] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7464B6] transition-colors">
                                Place Order
                            </button>

                            <!-- Payment Modal -->
                            <div x-show="showModal" 
                                 x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                 style="display: none;">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                    <!-- Background overlay -->
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>

                                    <!-- Modal panel -->
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-50">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment Details</h3>
                                                    <div class="mt-2">
                                                        <div class="bg-gray-50 rounded-lg p-6">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div>
                                                                    <h4 class="text-sm font-medium text-gray-900 mb-4">Order Summary</h4>
                                                                    <div class="space-y-3 text-sm">
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Pay to</span>
                                                                            <span class="font-medium">Wandering Pages</span>
                                                                        </div>
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Order info</span>
                                                                            <span class="break-all font-medium" id="modal-order-info">{{ $orderInfo }}</span>
                                                                        </div>
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Name</span>
                                                                            <span class="font-medium">{{ $user->first_name . ' ' . $user->last_name ?? $user->username }}</span>
                                                                        </div>
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Address</span>
                                                                            <span class="font-medium">{{ $user->address }}</span>
                                                                        </div>
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Order amount</span>
                                                                            <span class="font-medium" x-text="'$' + subtotal.toFixed(2)"></span>
                                                                        </div>
                                                                        <div class="flex justify-between">
                                                                            <span class="text-gray-500">Transaction no.</span>
                                                                            <span class="break-all font-medium" id="modal-transaction-no">{{ $transactionNo }}</span>
                                                                        </div>
                                                                        <div class="border-t border-gray-200 pt-3 mt-3">
                                                                            <div class="flex justify-between">
                                                                                <span class="font-medium">Total to pay</span>
                                                                                <span class="font-medium text-[#7464B6]" x-text="'$' + total.toFixed(2)"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex flex-col items-center">
                                                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=payment" alt="QR Code" class="w-36 h-36 rounded-lg bg-white p-2 shadow-sm mb-4">
                                                                    <p class="text-sm text-gray-500 text-center">Scan QR code to make payment</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <form id="payment-modal-form" class="mt-3">
                                                            <input type="hidden" name="transaction_no" value="{{ $transactionNo }}">
                                                            <input type="hidden" name="payment_method" x-model="paymentMethod">
                                                            <input type="hidden" name="shipping_method" x-model="shippingMethod">
                                                            
                                                            <div class="mt-4">
                                                                <label class="block">
                                                                    <span class="text-sm font-medium text-gray-700">Payment Proof</span>
                                                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-purple-500 transition-colors">
                                                                        <div class="space-y-1 text-center">
                                                                            <input type="file" 
                                                                                   id="payment_proof" 
                                                                                   name="payment_proof" 
                                                                                   class="hidden" 
                                                                                   accept="image/*" 
                                                                                   required 
                                                                                   @change="handlePaymentProofUpload($event)">
                                                                            <button type="button" 
                                                                                    @click="document.getElementById('payment_proof').click()" 
                                                                                    class="flex items-center justify-center gap-2 px-3 py-2 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5v-9m0 0L8.25 7.5m3.75 0l3.75 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                                <span id="upload-text">Upload Payment Photo</span>
                                                                            </button>
                                                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <div id="preview-container" class="hidden mt-4">
                                                                    <img id="preview-image" src="" alt="Payment Proof Preview" class="max-w-full h-32 object-contain rounded-lg">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button @click="submitOrder()" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#7464B6] text-base font-medium text-white hover:bg-[#6354A0] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7464B6] sm:ml-3 sm:w-auto sm:text-sm">
                                                Complete Payment
                                            </button>
                                            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('checkout', () => ({
        selectedItems: [],
        subtotal: 0,
        shippingFee: 20,
        shippingMethod: 'standard',
        paymentMethod: 'GCash',
        init() {
            const storedItems = sessionStorage.getItem('checkoutItems');
            if (storedItems) {
                this.selectedItems = JSON.parse(storedItems);
                this.calculateSubtotal();
            }
        },
        calculateSubtotal() {
            this.subtotal = this.selectedItems.reduce((sum, item) => sum + (item.book.price * item.quantity), 0);
        },
        get total() {
            return this.subtotal + this.shippingFee;
        },
        updateShipping(method) {
            this.shippingMethod = method;
            this.shippingFee = method === 'express' ? 50 : 20;
        },
        handlePaymentProofUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-text').textContent = 'Change Payment Photo';
                };
                reader.readAsDataURL(file);
            }
        },
        submitOrder() {
            const form = document.getElementById('payment-modal-form');
            const formData = new FormData(form);
            
            // Validate payment proof
            const paymentProof = document.getElementById('payment_proof').files[0];
            if (!paymentProof) {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Proof Required',
                    text: 'Please upload your payment proof before proceeding.'
                });
                return;
            }

            // Add the payment proof file to formData
            formData.append('payment_proof', paymentProof);

            // Add selected items to formData
            formData.append('selected_items', JSON.stringify(this.selectedItems));

            // Submit the order
            fetch('{{ route("order.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the selected items from session storage after successful order
                    sessionStorage.removeItem('checkoutItems');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Placed Successfully',
                        text: 'Your order has been placed and is pending confirmation.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '{{ route("orders.pending") }}';
                    });
                } else {
                    throw new Error(data.error || 'Failed to place order');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to place order. Please try again.'
                });
            });
        }
    }));
});
</script>
@endsection