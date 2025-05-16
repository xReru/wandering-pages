@extends('layouts.dashboard')

@section('content')
<div class="bg-[#F6F6FF] min-h-screen py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-1">My Likes</h2>
        <div class="text-sm text-gray-600 mb-6">{{ $customer->full_name }}</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($likes as $like)
                @php $book = $like->book; @endphp
                <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                    <img src="{{ $book->image ? Storage::url($book->image) : '/api/placeholder/320/480' }}" alt="{{ $book->title }}" class="h-40 w-28 object-contain rounded mb-2" onerror="this.src='/api/placeholder/320/480';this.onerror='';">
                    <div class="text-center flex-1 flex flex-col justify-between w-full">
                        <div>
                            <div class="font-semibold text-base truncate">{{ $book->title }}</div>
                            <div class="text-xs text-gray-500 mb-1 truncate">{{ $book->author }}</div>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-purple-700 font-bold text-sm">${{ number_format($book->price, 2) }}</span>
                            <button class="ml-2" onclick="removeLike({{ $book->id }}, this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-400 py-12">No liked books yet.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
function removeLike(bookId, btn) {
    if (!confirm('Remove this book from your likes?')) return;
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
            // Remove the card from the UI
            btn.closest('.bg-white').remove();
        } else {
            alert('Failed to remove like.');
        }
    })
    .catch(() => alert('Failed to remove like.'));
}
</script>
@endsection 