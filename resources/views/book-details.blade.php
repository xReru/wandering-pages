@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-7xl">
    <!-- Book Details Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 md:p-8">
            <!-- Book Image Section -->
            <div class="md:col-span-1 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <img src="{{ Storage::url($book->image) ?? '/api/placeholder/320/480' }}"
                         alt="{{ $book->title }} by {{ $book->author }}"
                         class="w-full h-auto object-cover rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300"
                         onerror="this.src='/api/placeholder/320/480';this.onerror='';">
                </div>
            </div>

            <!-- Book Information Section -->
            <div class="md:col-span-2 space-y-6">
                <div class="space-y-4">
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">{{ $book->genre }}</span>
                    <h1 class="text-3xl md:text-4xl font-bold font-['EBGaramond'] text-gray-900 leading-tight">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-700 font-['EBGaramond']">
                        By <a href="#" class="text-purple-700 hover:text-purple-800 transition-colors duration-200 font-medium">{{ $book->author }}</a>
                    </p>
                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold text-purple-700 font-['EBGaramond']">${{ number_format($book->price, 2) }}</span>
                        @if($book->quantity <= 0)
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Out of Stock</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">In Stock</span>
                        @endif
                    </div>
                </div>

                <div class="prose max-w-none text-gray-600 font-['EBGaramond']">
                    {{ $book->description }}
                </div>

                @if($book->quantity <= 0)
                    <div class="mt-6">
                        <span class="text-red-600 font-semibold">Out of Stock</span>
                    </div>
                @elseif(Auth::guard('customer')->check())
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mt-6" x-data="{
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
                        <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-2">
                            <button class="w-8 h-8 flex items-center justify-center bg-white rounded-md shadow-sm hover:bg-gray-100 transition-colors" @click="if(qty > 1) qty--">-</button>
                            <span class="w-8 text-center font-medium" x-text="qty"></span>
                            <button class="w-8 h-8 flex items-center justify-center bg-white rounded-md shadow-sm hover:bg-gray-100 transition-colors" @click="qty++">+</button>
                        </div>
                        <button class="flex-1 bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-800 transition-colors duration-200 shadow-sm hover:shadow-md" @click="addToCart">
                            Add to Cart
                        </button>
                        <button @click="toggleLike" :aria-label="liked ? 'Remove from likes' : 'Add to likes'" 
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-110 active:scale-95">
                            <i :class="liked ? 'fas fa-heart text-[#6751C5]' : 'far fa-heart text-[#6751C5]'" class="text-xl transition-colors duration-200"></i>    
                        </button>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="/login" class="inline-block bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-800 transition-colors duration-200 shadow-sm hover:shadow-md">
                            Sign in to add to cart
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12 bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6 font-['EBGaramond'] text-gray-900">Customer Reviews ({{ $book->ratings->count() }})</h2>
            @if($ratings->count() > 0)
                <div class="space-y-6">
                    @foreach($ratings as $rating)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-purple-700 font-medium">
                                            {{ substr($rating->user->username, 0, 2) . str_repeat('*', strlen($rating->user->username) - 2) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($rating->review)
                                <p class="text-gray-700 font-['EBGaramond'] leading-relaxed">{{ $rating->review }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($ratings->hasPages())
                    <div class="mt-8">
                        {{ $ratings->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">No reviews yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Books Section -->
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