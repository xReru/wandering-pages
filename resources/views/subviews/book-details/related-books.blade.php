@if($relatedBooks->count())
<div class="mt-8 bg-[#f4f3ff] rounded-lg p-6">
    <h2 class="text-xl font-bold mb-6 font-['EBGaramond']">Related Products</h2>
    <div class="flex overflow-x-auto gap-8 md:grid md:grid-cols-4 md:gap-8 md:overflow-visible">
        @foreach($relatedBooks as $related)
            <div class="flex flex-col w-40 min-w-[160px] md:w-auto md:min-w-0">
                <img src="{{ Storage::url($related->image) ?? '/api/placeholder/320/480' }}"
                     alt="{{ $related->title }} by {{ $related->author }}"
                     class="h-56 w-full object-contain rounded mb-2"
                     onerror="this.src='/api/placeholder/320/480';this.onerror='';">
                <span class="text-xs text-gray-500 font-['EBGaramond'] mb-1">{{ $related->genre }}</span>
                <h3 class="text-base font-semibold font-['EBGaramond'] leading-tight mb-1">{{ $related->title }}</h3>
                <span class="text-xs text-gray-700 font-['EBGaramond'] mb-2">{{ $related->author }}</span>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-[#6c47ff] font-bold text-sm font-['EBGaramond']">${{ number_format($related->price, 2) }}</span>
                    <button class="ml-2 text-gray-400 hover:text-[#6c47ff] transition p-0.5" aria-label="Add to wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480" fill="currentColor" class="w-5 h-5">
                            <path d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1 c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3 l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4 C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3 s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4 c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3 C444.801,187.101,434.001,213.101,414.401,232.701z"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif 