@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $orderInfo = Str::random(10);
    $transactionNo = random_int(1000000000000000, 9999999999999999);
    $subtotal = $cart->items->sum(fn($i) => $i->book->price * $i->quantity);
@endphp

@section('content')
<div class="min-h-screen bg-white flex flex-col md:flex-row">
    <!-- Left: Shipping & Payment -->
    <div class="w-full md:flex-1 px-4 md:px-8 py-6 md:py-10">
        <h2 class="text-lg font-serif font-semibold mb-2 tracking-wide">CHECKOUT</h2>
        <hr class="mb-6">
        <div class="mb-8">
            <h3 class="text-md font-semibold mb-2 text-gray-700">SHIPPING INFORMATION</h3>
            <div class="space-y-1 text-sm">
                <div><span class="font-semibold text-purple-700">Full Name:</span> <span class="text-gray-800">{{ $user->name ?? $user->username }}</span></div>
                <div><span class="font-semibold text-purple-700">Phone:</span> <span class="text-gray-800">{{ $user->phone_number ?? 'N/A' }}</span></div>
                <div><span class="font-semibold text-purple-700">Address:</span> <span class="text-gray-800">{{ $user->address ?? 'N/A' }}</span></div>
            </div>
        </div>
        <div class="mb-8">
            <h3 class="text-md font-semibold mb-2 text-gray-700">PAYMENT METHOD</h3>
            <form id="payment-form" class="space-y-4">
                <div class="flex items-center space-x-3">
                    <input type="radio" id="applepay" name="payment_method" value="Apple Pay" class="accent-purple-700">
                    <label for="applepay" class="flex items-center cursor-pointer text-sm md:text-base">
                        <img src="{{ asset('images/apple_pay.png') }}" alt="Apple Pay" class="h-6 w-6 mr-2"> Apple Pay
                    </label>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="radio" id="googlepay" name="payment_method" value="Google Pay" class="accent-purple-700">
                    <label for="googlepay" class="flex items-center cursor-pointer text-sm md:text-base">
                        <img src="{{ asset('images/google_pay.png') }}" alt="Google Pay" class="h-6 w-6 mr-2"> Google Pay
                    </label>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="radio" id="gcash" name="payment_method" value="GCash" class="accent-purple-700" checked>
                    <label for="gcash" class="flex items-center cursor-pointer text-sm md:text-base">
                        <img src="{{ asset('images/gcash.png') }}" alt="GCash" class="h-6 w-6 mr-2"> GCash
                    </label>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="radio" id="paypal" name="payment_method" value="Paypal" class="accent-purple-700">
                    <label for="paypal" class="flex items-center cursor-pointer text-sm md:text-base">
                        <img src="{{ asset('images/paypal.png') }}" alt="Paypal" class="h-6 w-6 mr-2"> Paypal
                    </label>
                </div>
            </form>
        </div>
        <div class="mb-8">
            <h3 class="text-md font-semibold mb-2 text-gray-700">SHIPPING METHOD</h3>
            <form id="shipping-method-form" class="space-y-3">
                <div class="flex items-start space-x-3">
                    <input type="radio" id="standard_shipping" name="shipping_method" value="standard" class="accent-purple-700 mt-1" checked>
                    <label for="standard_shipping" class="flex flex-col cursor-pointer text-sm md:text-base">
                        <span class="font-semibold">Standard Shipping</span>
                        <span class="text-gray-500 text-xs">Standard Shipping: $20 (5 days - 7 days delivery time)</span>
                    </label>
                </div>
                <div class="flex items-start space-x-3">
                    <input type="radio" id="express_shipping" name="shipping_method" value="express" class="accent-purple-700 mt-1">
                    <label for="express_shipping" class="flex flex-col cursor-pointer text-sm md:text-base">
                        <span class="font-semibold">Express Shipping</span>
                        <span class="text-gray-500 text-xs">Express Shipping: $50 (2 days - 5 days delivery time)</span>
                    </label>
                </div>
            </form>
        </div>
    </div>
    <!-- Right: Order Summary -->
    <div class="w-full md:w-[420px] bg-purple-50 px-4 md:px-8 py-6 md:py-10 flex flex-col min-h-[400px] md:min-h-screen">
        <h2 class="text-lg font-serif font-semibold mb-4">ORDER SUMMARY</h2>
        <div class="flex-1">
            @if($cart && $cart->items->count())
                <div class="space-y-6">
                    @foreach($cart->items as $item)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 border-b pb-4">
                            <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" alt="{{ $item->book->title }}" class="h-20 w-16 object-cover rounded shadow">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 text-sm md:text-base">{{ $item->book->title }}</div>
                                <div class="text-xs text-gray-600 mt-1">{{ $item->quantity }}x</div>
                                <div class="text-purple-700 font-semibold mt-1 text-sm md:text-base">${{ number_format($item->book->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-sm" id="order-summary-prices">
                    <div class="flex justify-between mb-1"><span>Subtotal:</span> <span id="summary-subtotal">${{ number_format($cart->items->sum(fn($i) => $i->book->price * $i->quantity), 2) }}</span></div>
                    <div class="flex justify-between mb-1"><span>Shipping fee:</span> <span id="summary-shipping">$20.00</span></div>
                    <hr class="my-2">
                    <div class="flex justify-between font-bold text-lg"><span>Total:</span> <span id="summary-total">${{ number_format($cart->items->sum(fn($i) => $i->book->price * $i->quantity) + 20, 2) }}</span></div>
                </div>
                <form class="mt-4 flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="text" placeholder="Enter Code" class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-300 text-sm">
                    <button type="button" class="px-4 py-2 bg-purple-200 text-purple-800 rounded hover:bg-purple-300 transition text-sm">Apply</button>
                </form>
                <div class="text-xs text-gray-500 mt-2 mb-6">Nemo enim ipsam voluptatem quia voluptas sit asper natur aut odit aut fugit</div>
            @else
                <div class="text-gray-500">Your cart is empty.</div>
            @endif
        </div>
        <div x-data="{ showModal: false }">
            <button id="place-order-btn" @click="showModal = true" class="w-full mt-4 bg-purple-700 text-white py-3 rounded font-bold text-lg hover:bg-purple-800 transition">PLACE ORDER</button>
            <div id="payment-modal" x-show="showModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-[1px]" style="display: none;">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 p-6 relative flex flex-col">
                    <h2 class="text-lg font-serif font-semibold mb-1">PAYMENT</h2>
                    <p class="text-sm text-gray-600 mb-4">Scan this QR code and upload it to pay</p>
                    <hr class="mb-4">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                        <div class="flex-1 w-full">
                            <h3 class="font-semibold text-md mb-2">Order Summary</h3>
                            <div class="text-sm space-y-1 mb-2">
                                <div class="flex justify-between"><span class="text-gray-500">Pay to</span> <span class="font-medium">Wandering Pages</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Order info</span> <span class="break-all" id="modal-order-info">{{ $orderInfo }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Name</span> <span class="font-medium">{{ $user->first_name . ' ' . $user->last_name ?? $user->username }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Address</span> <span class="font-medium">{{ $user->address }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Order amount</span> <span id="modal-order-amount">${{ number_format($subtotal, 2) }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Transaction no.</span> <span class="break-all" id="modal-transaction-no">{{ $transactionNo }}</span></div>
                                <div class="flex justify-between font-bold text-base mt-2"><span>Total to pay</span> <span class="text-purple-700" id="modal-total">${{ number_format($subtotal + 20, 2) }}</span></div>
                            </div>
                            <form id="payment-modal-form" class="space-y-4">
                                <input type="hidden" name="transaction_no" value="{{ $transactionNo }}">
                                <input type="hidden" name="payment_method" id="payment-method" value="GCash">
                                <input type="hidden" name="shipping_method" id="shipping-method" value="standard">
                                <div class="relative">
                                    <input type="file" id="payment_proof" name="payment_proof" class="hidden" accept="image/*" required>
                                    <button type="button" onclick="document.getElementById('payment_proof').click()" class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-gray-100 rounded text-sm font-medium text-gray-700 hover:bg-gray-200 transition mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5v-9m0 0L8.25 7.5m3.75 0l3.75 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span id="upload-text">Upload Payment Photo</span>
                                    </button>
                                    <div id="preview-container" class="hidden mt-2">
                                        <img id="preview-image" src="" alt="Payment Proof Preview" class="max-w-full h-32 object-contain rounded">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=payment" alt="QR Code" class="w-36 h-36 rounded bg-gray-100 border mb-2">
                        </div>
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button id="submit-order-btn" class="w-full bg-purple-700 text-white py-2 rounded font-bold text-base hover:bg-purple-800 transition">Done</button>
                        <button @click="showModal = false" type="button" class="w-full bg-gray-200 text-gray-700 py-2 rounded font-bold text-base hover:bg-gray-300 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const placeOrderBtn = document.getElementById('place-order-btn');
    const paymentModal = document.getElementById('payment-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');
    const shippingForm = document.getElementById('shipping-method-form');
    const summaryShipping = document.getElementById('summary-shipping');
    const summaryTotal = document.getElementById('summary-total');
    const modalTotal = document.getElementById('modal-total');
    const modalOrderAmount = document.getElementById('modal-order-amount');
    const subtotal = parseFloat(document.getElementById('summary-subtotal').textContent.replace('$', ''));

    function updateShipping() {
        let shippingFee = shippingForm.querySelector('input[name="shipping_method"]:checked').value === 'express' ? 50 : 20;
        summaryShipping.textContent = `$${shippingFee.toFixed(2)}`;
        summaryTotal.textContent = `$${(subtotal + shippingFee).toFixed(2)}`;
        modalTotal.textContent = `$${(subtotal + shippingFee).toFixed(2)}`;
        modalOrderAmount.textContent = `$${subtotal.toFixed(2)}`;
    }

    shippingForm.addEventListener('change', updateShipping);

    placeOrderBtn?.addEventListener('click', function(e) {
        e.preventDefault();
        paymentModal.classList.remove('hidden');
        updateShipping();
    });
    closeModalBtn?.addEventListener('click', function() {
        paymentModal.classList.add('hidden');
    });
    cancelModalBtn?.addEventListener('click', function() {
        paymentModal.classList.add('hidden');
    });

    // Handle payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('payment-method').value = this.value;
        });
    });

    // Handle shipping method selection
    document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('shipping-method').value = this.value;
            updateShipping();
        });
    });

    // Handle payment proof upload
    document.getElementById('payment_proof').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
                document.getElementById('upload-text').textContent = 'Change Payment Photo';
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle order submission
    document.getElementById('submit-order-btn').addEventListener('click', function() {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Order Placed Successfully',
                    text: 'Your order has been placed and is pending confirmation.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '{{ route("orders.index") }}';
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
    });
</script>
@endsection 