@forelse($books as $book)
    <a href="{{ route('books.show', $book->id) }}" class="bg-white rounded-lg shadow flex flex-col items-center p-4 transition hover:shadow-lg">
        <img 
            src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}" 
            alt="{{ $book->title }} by {{ $book->author }}" 
            class="h-48 w-full object-contain mb-4 rounded"
            onerror="this.src='/api/placeholder/320/480';this.onerror='';"
        >
        <div class="w-full flex flex-col flex-1 justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1 font-['EBGaramond']">{{ $book->genre }}</p>
                <h3 class="text-base font-semibold text-gray-800 leading-tight mb-1 font-['EBGaramond']">{{ $book->title }}</h3>
                <p class="text-sm text-gray-600 mb-2 font-['EBGaramond']">by {{ $book->author }}</p>
            </div>
            <div class="flex items-center justify-between mt-2">
                <span class="text-purple-700 font-bold text-lg font-['EBGaramond']">${{ number_format($book->price, 2) }}</span>
            </div>
        </div>
    </a>
@empty
    <div class="col-span-full text-center text-gray-500 py-12 font-['EBGaramond']">No books found.</div>
@endforelse

@if($books->hasPages())
    <div class="col-span-full mt-8 flex justify-center">
        {{ $books->links() }}
    </div>
@endif 