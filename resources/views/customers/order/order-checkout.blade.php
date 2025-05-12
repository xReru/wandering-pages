@extends('layouts.app')

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
                <div class="mt-6 text-sm">
                    <div class="flex justify-between mb-1"><span>Subtotal:</span> <span>${{ number_format($cart->items->sum(fn($i) => $i->book->price * $i->quantity), 2) }}</span></div>
                    <div class="flex justify-between mb-1"><span>Shipping fee:</span> <span>$18.00</span></div>
                    <hr class="my-2">
                    <div class="flex justify-between font-bold text-lg"><span>Total:</span> <span>${{ number_format($cart->items->sum(fn($i) => $i->book->price * $i->quantity) + 18, 2) }}</span></div>
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
        <button class="w-full mt-4 bg-purple-700 text-white py-3 rounded font-bold text-lg hover:bg-purple-800 transition">PLACE ORDER</button>
    </div>
</div>
@endsection 