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
            @if(Auth::guard('customer')->check())
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
                <button @click="toggleLike" :aria-label="liked ? 'Remove from likes' : 'Add to likes'" class="ml-2 focus:outline-none">
                    <svg x-show="!liked" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7 text-pink-400">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                    <svg x-show="liked" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-7 h-7 text-pink-500">
                        <path d="M12.1 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54l-1.35 1.31z" />
                    </svg>
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
        <h2 class="text-xl font-bold mb-4 font-['EBGaramond']">Reviews (0)</h2>
        <div class="text-gray-500">No reviews yet.</div>
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