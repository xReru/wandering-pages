@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8 bg-white rounded-lg shadow p-6">
        <div class="flex-shrink-0">
            <img src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}"
                 alt="{{ $book->title }} by {{ $book->author }}"
                 class="h-80 w-56 object-contain rounded mb-4"
                 onerror="this.src='/api/placeholder/320/480';this.onerror='';">
        </div>
        <div class="flex-1 flex flex-col">
            <span class="text-xs text-gray-500 mb-2 font-['EBGaramond']">{{ $book->genre }}</span>
            <h1 class="text-3xl font-bold font-['EBGaramond'] mb-2">{{ $book->title }}</h1>
            <p class="text-lg mb-2 font-['EBGaramond']">Author: <a href="#" class="text-purple-700 hover:underline">{{ $book->author }}</a></p>
            <span class="text-purple-700 font-bold text-2xl mb-4 font-['EBGaramond']">${{ number_format($book->price, 2) }}</span>
            <p class="mb-4 text-gray-700 font-['EBGaramond']">{{ $book->description }}</p>
            @if($book->quantity <= 0)
                <div class="mb-6">
                    <span class="text-red-600 font-semibold">Out of Stock</span>
                </div>
            @elseif(Auth::guard('customer')->check())
            <div class="flex items-center gap-2 mb-6" x-data="{
                qty: 1,
                liked: {{ $liked ? 'true' : 'false' }},
                toggleLike() {
                    const token = document.querySelector('meta[name=csrf-token]').content;
                    const method = this.liked ? 'DELETE' : 'POST';
                    fetch('/likes', {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ book_id: {{ $book->id }} })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.liked = !this.liked;
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: this.liked ? 'Added to likes!' : 'Removed from likes!'
                            });
                        } else {
                            throw new Error('Failed to update like');
                        }
                    })
                    .catch(() => {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update like. Please try again.'
                        });
                    });
                },
                addToCart() { 
                    const token = document.querySelector('meta[name=csrf-token]').content;
                    fetch('/cart/add', { 
                        method: 'POST', 
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }, 
                        body: JSON.stringify({ 
                            book_id: {{ $book->id }}, 
                            quantity: this.qty 
                        }) 
                    })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            $store.cart.fetchCart();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Item added to cart successfully!'
                            });
                        } else {
                            throw new Error(data.error || 'Failed to add item to cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to add item to cart. Please try again.'
                        });
                    });
                } 
            }">
                <button class="bg-gray-200 px-2 py-1 rounded" @click="if(qty > 1) qty--">-</button>
                <span x-text="qty"></span>
                <button class="bg-gray-200 px-2 py-1 rounded" @click="qty++">+</button>
                <button class="ml-4 bg-purple-700 text-white px-6 py-2 rounded font-bold hover:bg-purple-800 transition" @click="addToCart">ADD TO CART</button>
                <button @click="toggleLike" :aria-label="liked ? 'Remove from likes' : 'Add to likes'" class="ml-2 focus:outline-none transition-all duration-200 transform hover:scale-110 active:scale-95">
                    <i :class="liked ? 'fas fa-heart text-[#6751C5]' : 'far fa-heart text-[#6751C5]'" class="transition-colors duration-200 hover:text-[#5440AA]"></i>    
                </button>
            </div>
            @else
            <div class="flex items-center gap-2 mb-6">
                <a href="/login" class="ml-4 bg-purple-700 text-white px-6 py-2 rounded font-bold hover:bg-purple-800 transition">Sign in to add to cart</a>
            </div>
            @endif
            <div>
                <span class="text-xs text-gray-500">Category: {{ $book->genre }}</span>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-gray-100 rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 font-['EBGaramond']">Reviews ({{ $book->ratings->count() }})</h2>
        @if($ratings->count() > 0)
            <div class="space-y-6">
                @foreach($ratings as $rating)
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-700">
                                    {{ substr($rating->user->username, 0, 2) . str_repeat('*', strlen($rating->user->username) - 2) }}
                                </span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($rating->review)
                            <p class="text-gray-700 font-['EBGaramond']">{{ $rating->review }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            @if($ratings->hasPages())
                <div class="mt-6">
                    {{ $ratings->links() }}
                </div>
            @endif
        @else
            <div class="text-gray-500">No reviews yet.</div>
        @endif
    </div>
    @include('subviews.book-details.related-books', ['relatedBooks' => $relatedBooks])
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<style>
.colored-toast.swal2-icon-success {
    background-color: #a5dc86 !important;
}
.colored-toast.swal2-icon-error {
    background-color: #f27474 !important;
}
.colored-toast .swal2-title {
    color: white;
}
.colored-toast .swal2-close {
    color: white;
}
.colored-toast .swal2-html-container {
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    window.cartModal = window.cartModal || function() { return Alpine.store('cartModal'); };
});
</script>
@endpush 