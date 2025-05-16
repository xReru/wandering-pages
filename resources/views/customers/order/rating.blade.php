@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-[#f3f1fc] py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-xl font-sans font-medium mb-2">My Ratings</h1>
        <hr class="border-t border-gray-400 mb-6">

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">You have no completed orders.</p>
                <a href="/browse-books" class="inline-block mt-4 px-6 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Browse Books</a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row md:justify-between md:items-stretch border border-gray-200">
                        <div class="flex flex-col gap-2 w-full md:w-2/3">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 items-center">
                                    <img src="{{ Storage::url($item->book->image) ?? $item->book->image ?? '/default-cover.jpg' }}" alt="Book Cover" class="w-20 h-28 object-cover rounded shadow border border-gray-200" />
                                    <div>
                                        <div class="font-serif text-lg">{{ $item->book->title }}</div>
                                        <div class="text-[15px] text-purple-600 font-semibold">${{ number_format($item->book->price, 2) }}</div>
                                        @if($item->rating && $item->rating->review)
                                            <div class="text-gray-600 italic text-sm mt-1">"{{ $item->rating->review }}"</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex flex-col justify-between items-end w-full md:w-1/3 mt-4 md:mt-0 h-full">
                            <div class="text-right mb-2">
                                <div class="text-sm text-gray-700">Subtotal: <span class="text-purple-500 font-medium">${{ number_format($order->subtotal, 2) }}</span></div>
                                <div class="text-sm text-gray-700">Shipping Fee: <span class="text-purple-500 font-medium">${{ number_format($order->shipping_fee, 2) }}</span></div>
                                <div class="font-bold text-lg mt-1">Order Total: <span class="text-purple-500">${{ number_format($order->total_amount, 2) }}</span></div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                @if(!$item->rating)
                                    <div x-data="{ open: false, rating: 0, hover: 0, review: '' }" class="relative">
                                        <button @click="open = true" class="border border-purple-400 text-purple-700 px-4 py-2 rounded hover:bg-purple-50 text-xs">Leave a Rating</button>
                                        <!-- Modal -->
                                        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display: none;">
                                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-2 relative">
                                                <button @click="open = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                                                <div class="flex gap-4 items-center mb-4">
                                                    <img src="{{ Storage::url($item->book->image) ?? $item->book->image ?? '/default-cover.jpg' }}" alt="Book Cover" class="w-16 h-24 object-cover rounded shadow border border-gray-200" />
                                                    <div>
                                                        <div class="font-serif text-lg font-semibold">{{ $item->book->title }}</div>
                                                        <div class="text-sm text-gray-500">by {{ $item->book->author }}</div>
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('ratings.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="book_id" value="{{ $item->book->id }}">
                                                    <div class="flex items-center mb-2 justify-center">
                                                        <template x-for="i in 5">
                                                            <svg @mouseenter="hover = i" @mouseleave="hover = 0" @click="rating = i" :fill="i <= (hover || rating) ? '#facc15' : 'none'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="#facc15" class="w-8 h-8 cursor-pointer">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.29a1 1 0 00.95.69h6.631c.969 0 1.371 1.24.588 1.81l-5.37 3.905a1 1 0 00-.364 1.118l2.036 6.29c.3.921-.755 1.688-1.54 1.118l-5.37-3.905a1 1 0 00-1.176 0l-5.37 3.905c-.784.57-1.838-.197-1.54-1.118l2.036-6.29a1 1 0 00-.364-1.118L2.342 11.717c-.783-.57-.38-1.81.588-1.81h6.631a1 1 0 00.95-.69l2.036-6.29z" />
                                                            </svg>
                                                        </template>
                                                        <input type="hidden" name="rating" x-model="rating">
                                                    </div>
                                                    <textarea name="review" x-model="review" class="w-full p-2 rounded border border-gray-300" rows="3" placeholder="Write a review (optional)"></textarea>
                                                    <div class="flex justify-end mt-4">
                                                        <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 text-xs">Submit Rating</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 text-xs">Buy Again</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 