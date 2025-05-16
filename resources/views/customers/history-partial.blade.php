@if($orders->isEmpty())
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <p class="text-gray-500">{{ $emptyText }}</p>
        <a href="{{--route('books.index')--}}" class="inline-block mt-4 px-6 py-2 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Browse Books</a>
    </div>
@else
    <div class="space-y-8">
        @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row md:justify-between md:items-stretch border border-gray-200">
                <div class="flex flex-col gap-2 w-full md:w-2/3">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 items-center">
                            <img src="{{ $item->book->image ? Storage::url($item->book->image) : '/api/placeholder/320/480' }}" alt="Book Cover" class="w-16 h-24 object-cover rounded shadow border border-gray-200" />
                            <div>
                                <div class="font-serif text-base md:text-lg">{{ $item->book->title }}</div>
                                <div class="text-[15px] text-purple-600 font-semibold">${{ number_format($item->price_at_time_of_order ?? $item->book->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col justify-between items-end w-full md:w-1/3 mt-4 md:mt-0 h-full">
                    <div class="text-right mb-2">
                        <div class="text-sm text-gray-700">Subtotal: <span class="text-purple-500 font-medium">${{ number_format(($order->total_amount ?? 0) - ($order->shipping_fee ?? 0), 2) }}</span></div>
                        <div class="text-sm text-gray-700">Shipping Fee: <span class="text-purple-500 font-medium">${{ number_format($order->shipping_fee ?? 0, 2) }}</span></div>
                        <div class="font-bold text-lg mt-1">Order Total: <span class="text-purple-500">${{ number_format($order->total_amount ?? 0, 2) }}</span></div>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <a href="{{--route('books.index')--}}" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 text-xs">Buy Again</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif 