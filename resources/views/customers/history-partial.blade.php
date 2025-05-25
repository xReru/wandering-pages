@if($orders->isEmpty())
    <div class="bg-white rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm sm:text-base">{{ $emptyText }}</p>
        <a href="{{--route('books.index')--}}" class="inline-block mt-4 px-5 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow-sm">Browse Books</a>
    </div>
@else
    <div class="space-y-4">
        @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Book Items Section -->
                        <div class="lg:col-span-2 space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 items-start">
                                    <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" 
                                         alt="Book Cover" 
                                         class="w-16 h-24 object-cover rounded-md shadow-sm border border-gray-100" />
                                    <div class="flex-1">
                                        <h3 class="font-serif text-base sm:text-lg text-gray-800 line-clamp-2">{{ $item->book->title }}</h3>
                                        <div class="mt-1 text-sm sm:text-base text-[#7464B6] font-medium">$ {{ number_format($item->price_at_time_of_order ?? $item->book->price, 2) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary Section -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal</span>
                                        <span class="text-[#7464B6] font-medium">$ {{ number_format(($order->total_amount ?? 0) - ($order->shipping_fee ?? 0), 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Shipping Fee</span>
                                        <span class="text-[#7464B6] font-medium">$ {{ number_format($order->shipping_fee ?? 0, 2) }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2 mt-2">
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-800">Total</span>
                                            <span class="font-bold text-[#7464B6]">$ {{ number_format($order->total_amount ?? 0, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="/books/{{ $item->book->id }}" 
                                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#7464B6] text-white text-sm rounded-lg hover:bg-[#6354A0] transition-colors duration-200 shadow-sm">
                                        Buy Again
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif 