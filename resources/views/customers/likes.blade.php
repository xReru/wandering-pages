@extends('layouts.dashboard')

@section('content')
<div class="bg-gradient-to-br from-purple-50 to-indigo-50 min-h-screen py-4 px-3 sm:px-4 lg:px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-1">My Likes</h2>
            <div class="text-sm text-gray-600">{{ $customer->full_name }}</div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
            @forelse($likes as $like)
                @php $book = $like->book; @endphp
                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-200 overflow-hidden transform hover:-translate-y-0.5 transition-transform duration-200">
                    <!-- Book Image -->
                    <div class="relative aspect-[3/4] bg-gray-100">
                        <img src="{{ $book->image ? Storage::url($book->image) : '/api/placeholder/320/480' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='/api/placeholder/320/480';this.onerror='';">
                    </div>
                    
                    <!-- Book Details -->
                    <div class="p-2 sm:p-3">
                        <h3 class="font-medium text-sm sm:text-base text-gray-900 mb-0.5 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-2 line-clamp-1">{{ $book->author }}</p>
                        
                        <!-- Price and Action -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base font-bold text-purple-700">${{ number_format($book->price, 2) }}</span>
                            <button onclick="removeLike({{ $book->id }}, this)" 
                                    class="p-1.5 rounded-full hover:bg-red-50 transition-colors duration-200 group">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     fill="none" 
                                     viewBox="0 0 24 24" 
                                     stroke="currentColor" 
                                     class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 group-hover:text-red-500 transition-colors duration-200">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-8 px-4">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="mt-2 text-base font-medium text-gray-900">No liked books yet</h3>
                        <p class="mt-1 text-xs text-gray-500">Start adding books to your likes to see them here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function removeLike(bookId, btn) {
    if (!confirm('Remove this book from your likes?')) return;
    
    // Add loading state
    const card = btn.closest('.bg-white');
    card.classList.add('opacity-50', 'pointer-events-none');
    
    fetch('/likes', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Add fade-out animation
            card.style.transition = 'all 0.2s ease-out';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            
            // Remove the card after animation
            setTimeout(() => card.remove(), 200);
        } else {
            card.classList.remove('opacity-50', 'pointer-events-none');
            alert('Failed to remove like.');
        }
    })
    .catch(() => {
        card.classList.remove('opacity-50', 'pointer-events-none');
        alert('Failed to remove like.');
    });
}
</script>
@endsection 