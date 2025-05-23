@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-sans font-semibold text-gray-900">My Ratings</h1>
            <hr class="border-t border-gray-200 mt-2">
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-6 text-center max-w-md mx-auto">
                <p class="text-gray-600 mb-4">You have no completed orders.</p>
                <a href="/browse-books" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">Browse Books</a>
            </div>
        @else
            <div class="space-y-4 sm:space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <div class="lg:col-span-2 space-y-4">
                                    @foreach($order->items as $item)
                                        <div class="flex gap-4 items-start">
                                            <img src="{{ Storage::url($item->book->image) ?? $item->book->image ?? '/default-cover.jpg' }}" 
                                                 alt="Book Cover" 
                                                 class="w-16 h-24 sm:w-20 sm:h-28 object-cover rounded-lg shadow-sm border border-gray-100" />
                                            <div class="flex-grow min-w-0">
                                                <h3 class="font-serif text-base sm:text-lg font-medium text-gray-900 truncate">{{ $item->book->title }}</h3>
                                                <div class="text-sm text-purple-600 font-semibold">${{ number_format($item->book->price, 2) }}</div>
                                                @if($item->rating && $item->rating->review)
                                                    <div class="text-sm text-gray-600 italic mt-1">"{{ $item->rating->review }}"</div>
                                                @endif
                                                @if(!$item->rating)
                                                    <div x-data="{ open: false, rating: 0, hover: 0, review: '' }" class="relative mt-2">
                                                        <button @click="open = true" 
                                                                class="inline-flex items-center px-3 py-1.5 border border-purple-200 text-purple-700 text-xs font-medium rounded-lg hover:bg-purple-50 transition-colors duration-200">
                                                            Leave a Rating
                                                        </button>
                                                        <!-- Modal -->
                                                        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm" style="display: none;">
                                                            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 w-full max-w-md mx-4 relative">
                                                                <button @click="open = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                                <div class="flex gap-4 items-center mb-4">
                                                                    <img src="{{ Storage::url($item->book->image) ?? $item->book->image ?? '/default-cover.jpg' }}" 
                                                                         alt="Book Cover" 
                                                                         class="w-16 h-24 object-cover rounded-lg shadow-sm border border-gray-100" />
                                                                    <div class="min-w-0">
                                                                        <h4 class="font-serif text-base font-semibold text-gray-900 truncate">{{ $item->book->title }}</h4>
                                                                        <p class="text-sm text-gray-500">by {{ $item->book->author }}</p>
                                                                    </div>
                                                                </div>
                                                                <form method="POST" action="{{ route('ratings.store') }}" class="space-y-4">
                                                                    @csrf
                                                                    <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                                    <input type="hidden" name="book_id" value="{{ $item->book->id }}">
                                                                    <div class="flex items-center justify-center gap-1">
                                                                        <template x-for="i in 5">
                                                                            <svg @mouseenter="hover = i" 
                                                                                 @mouseleave="hover = 0" 
                                                                                 @click="rating = i" 
                                                                                 :fill="i <= (hover || rating) ? '#facc15' : 'none'" 
                                                                                 xmlns="http://www.w3.org/2000/svg" 
                                                                                 viewBox="0 0 24 24" 
                                                                                 stroke="#facc15" 
                                                                                 class="w-6 h-6 sm:w-7 sm:h-7 cursor-pointer transition-transform hover:scale-110">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.29a1 1 0 00.95.69h6.631c.969 0 1.371 1.24.588 1.81l-5.37 3.905a1 1 0 00-.364 1.118l2.036 6.29c.3.921-.755 1.688-1.54 1.118l-5.37-3.905a1 1 0 00-1.176 0l-5.37 3.905c-.784.57-1.838-.197-1.54-1.118l2.036-6.29a1 1 0 00-.364-1.118L2.342 11.717c-.783-.57-.38-1.81.588-1.81h6.631a1 1 0 00.95-.69l2.036-6.29z" />
                                                                            </svg>
                                                                        </template>
                                                                        <input type="hidden" name="rating" x-model="rating">
                                                                    </div>
                                                                    <textarea name="review" 
                                                                              x-model="review" 
                                                                              class="w-full p-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none" 
                                                                              rows="3" 
                                                                              placeholder="Write a review (optional)"></textarea>
                                                                    <div class="flex justify-end">
                                                                        <button type="submit" 
                                                                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                                                            Submit Rating
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="lg:col-span-1 flex flex-col justify-between space-y-4">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Subtotal:</span>
                                                <span class="text-purple-600 font-medium">${{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Shipping Fee:</span>
                                                <span class="text-purple-600 font-medium">${{ number_format($order->shipping_fee, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between text-base font-semibold pt-2 border-t border-gray-200">
                                                <span class="text-gray-900">Order Total:</span>
                                                <span class="text-purple-600">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                            Buy Again
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 