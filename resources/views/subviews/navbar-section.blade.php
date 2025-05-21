<head>@vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
</head>
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="logo text-gray-800">Wandering Pages</a>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="{{ route('browse-books') }}" class="text-gray-700 hover:text-gray-900">Shop</a>
                    <a href="{{ route('contact-us') }}" class="text-gray-700 hover:text-gray-900">Contact</a>
                </nav>
            </div>

            <!-- Search, Cart and Account -->
            <div class="flex items-center space-x-4" x-data="{ showUserModal: false, searchQuery: '', searchResults: [], isSearching: false, showResults: false, searchError: null }" x-init="$store.cart.init()">
                <div class="relative w-48 hidden md:block">
                    <input type="text" 
                           x-model="searchQuery"
                           @input.debounce.300ms="
                               if(searchQuery.length > 2) {
                                   isSearching = true;
                                   showResults = true;
                                   searchError = null;
                                   fetch('/search-books?query=' + encodeURIComponent(searchQuery))
                                       .then(response => {
                                           if (!response.ok) {
                                               throw new Error('Search failed. Please try again.');
                                           }
                                           return response.json();
                                       })
                                       .then(data => {
                                           if (data.error) {
                                               throw new Error(data.error);
                                           }
                                           searchResults = data;
                                           isSearching = false;
                                       })
                                       .catch(error => {
                                           console.error('Search error:', error);
                                           searchError = error.message;
                                           searchResults = [];
                                           isSearching = false;
                                       });
                               } else {
                                   searchResults = [];
                                   showResults = false;
                                   searchError = null;
                               }
                           "
                           @click.away="showResults = false"
                           class="w-full px-4 py-1 border border-gray-300 rounded-md" 
                           placeholder="Search books...">
                    <button class="absolute right-2 inset-y-0 flex items-center text-gray-400 search-icon-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <!-- Search Results Dropdown -->
                    <div x-show="showResults && searchResults.length > 0" 
                         class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg max-h-96 overflow-y-auto">
                        <template x-for="book in searchResults" :key="book.id">
                            <a :href="'/books/' + book.id" 
                               class="flex items-center p-3 hover:bg-gray-100 border-b border-gray-100">
                                <img :src="book.image_url" class="w-12 h-16 object-cover rounded shadow-sm mr-3" :alt="book.title">
                                <div>
                                    <div class="font-medium text-gray-900" x-text="book.title"></div>
                                    <div class="text-sm text-gray-600" x-text="book.author"></div>
                                    <div class="text-sm font-medium text-indigo-600">$<span x-text="book.price"></span></div>
                                </div>
                            </a>
                        </template>
                    </div>
                    
                    <!-- Loading State -->
                    <div x-show="isSearching" 
                         class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg p-3 text-center">
                        <i class="fas fa-spinner fa-spin text-indigo-600"></i>
                        <span class="ml-2 text-gray-600">Searching...</span>
                    </div>
                    
                    <!-- Error State -->
                    <div x-show="searchError" 
                         class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg p-3 text-center text-red-600">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="ml-2" x-text="searchError"></span>
                    </div>
                    
                    <!-- No Results -->
                    <div x-show="showResults && !isSearching && !searchError && searchResults.length === 0" 
                         class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg p-3 text-center text-gray-600">
                        No books found
                    </div>
                </div>
                @if(Auth::guard('customer')->check())
                <div class="flex items-center">
                    <span class="text-indigo-800 font-medium mr-1">$<span x-text="$store.cart.subtotal">0.00</span></span>
                    <div class="relative cursor-pointer" @click="$store.cart.open = true; $store.cart.fetchCart()">
                        <i class="fas fa-shopping-bag text-gray-700"></i>
                        <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" x-text="$store.cart.cartCount">0</span>
                    </div>
                </div>
                @endif
                <div class="text-gray-700 relative">
                    @if(Auth::guard('customer')->check())
                        <button @click="showUserModal = true" class="focus:outline-none">
                            <i class="fas fa-user-circle text-xl"></i>
                        </button>
                        <!-- User Modal -->
                        <div x-show="showUserModal" 
                             @click.away="showUserModal = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                             style="display: none;">
                            <div class="px-4 py-2 text-sm text-gray-700">
                                Welcome, {{ Auth::guard('customer')->user()->username }}
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="block" id="logout-form">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>

                        <script>
                            function confirmLogout() {
                                Swal.fire({
                                    title: 'Logout',
                                    text: 'Are you sure you want to logout?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#6B46C1',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, logout',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('logout-form').submit();
                                    }
                                });
                            }
                        </script>
                    @else
                        <a href="/login">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    @endif
                </div>
                
                <!-- Cart Modal -->
@if(Auth::guard('customer')->check())
<div x-show="$store.cart.open" class="fixed inset-0 flex justify-end z-50" style="display: none;">
    <div class="bg-white w-full max-w-md p-6 shadow-2xl h-full overflow-y-auto relative flex flex-col">
        <button @click="$store.cart.open = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>
        <template x-if="$store.cart.cart && $store.cart.cart.items && $store.cart.cart.items.length">
            <div class="flex-1">
                <template x-for="item in $store.cart.cart.items" :key="item.id">
                    <div class="flex items-center bg-gray-50 rounded-lg shadow-sm p-3 mb-4 group transition">
                        <input type="checkbox"
                            :checked="item.selected"
                            @change="!item.isOutOfStock && !item.isArchived && $store.cart.toggleItemSelection(item.id)"
                            :disabled="item.isOutOfStock || item.isArchived"
                            class="mr-3 h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer transition"
                            :class="{'opacity-50 cursor-not-allowed': item.isOutOfStock || item.isArchived}">
                        <img :src="item.book.image_url" class="h-16 w-12 object-cover rounded shadow-sm mr-3 border" alt="Book Cover">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold truncate" x-text="item.book.title"></span>
                                <template x-if="item.isArchived">
                                    <span class="ml-2 px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">BOOK UNAVAILABLE</span>
                                </template>
                                <template x-if="!item.isArchived && item.isOutOfStock">
                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded">OUT OF STOCK</span>
                                </template>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)"
                                    class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded text-sm font-bold transition"
                                    :disabled="item.quantity <= 1">-</button>
                                <span x-text="item.quantity" class="w-8 text-center font-medium"></span>
                                <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)"
                                    class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded text-sm font-bold transition">+</button>
                                <button @click="$store.cart.removeItem(item.id)"
                                    class="ml-2 text-red-500 hover:text-red-700 transition"
                                    title="Remove from cart">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <span class="ml-auto text-sm text-gray-700 font-semibold">
                                    $<span x-text="(item.book.price * item.quantity).toFixed(2)"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="mt-6 p-4 bg-purple-50 rounded-lg flex items-center justify-between font-bold text-lg shadow">
                    <span>Selected Items Subtotal:</span>
                    <span class="text-purple-700">$<span x-text="$store.cart.selectedSubtotal"></span></span>
                </div>
                <button class="mt-6 w-full !bg-gradient-to-r !from-purple-600 !to-indigo-600 text-white py-3 rounded-lg font-bold text-lg shadow hover:!from-purple-700 hover:!to-indigo-700 transition disabled:opacity-50"
                        @click.prevent="$store.cart.proceedToCheckout()"
                        :disabled="!$store.cart.hasSelectedItems">
                    CHECKOUT
                </button>
            </div>
        </template>
        <template x-if="!$store.cart.cart || !$store.cart.cart.items || $store.cart.cart.items.length === 0">
            <div class="text-gray-400 text-center mt-16">
                <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                <div>Your cart is empty.</div>
            </div>
        </template>
    </div>
</div>
@endif
            </div>
        </div>
    </div>
</header>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        open: false,
        cart: null,
        cartCount: 0,
        subtotal: '0.00',
        selectedSubtotal: '0.00',
        init() {
            if (document.querySelector('meta[name="csrf-token"]')) {
                this.fetchCart();
            }
        },
        fetchCart() {
            if (!document.querySelector('meta[name="csrf-token"]')) {
                console.error('CSRF token not found');
                return;
            }
            
            fetch('/cart', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                this.cart = data;
                if (this.cart && this.cart.items) {
                    this.cart.items.forEach(item => {
                        item.selected = false; // Initialize selection state
                        item.book.image_url = item.book.image.startsWith('http') ? item.book.image : '/storage/' + item.book.image;
                        // Ensure quantity is a number
                        item.quantity = parseInt(item.quantity) || 0;
                        
                        // Debug logging for initial values
                        console.log('Processing item:', {
                            title: item.book.title,
                            is_archived: item.book.is_archived,
                            quantity: item.book.quantity
                        });
                        
                        // Check if item is archived (handle both boolean and number values)
                        item.isArchived = item.book.is_archived === true || item.book.is_archived === 1;
                        console.log('Archived status:', item.isArchived);
                        
                        // Set out of stock status based on archived status
                        if (item.isArchived) {
                            item.isOutOfStock = false;
                            console.log('Item is archived, setting out of stock to false');
                        } else {
                            item.isOutOfStock = item.book.quantity < 1;
                            console.log('Item is not archived, checking stock:', item.isOutOfStock);
                        }
                    });
                }
                this.updateCartCounts();
            })
            .catch(error => {
                console.error('Error fetching cart:', error);
                this.cart = null;
                this.cartCount = 0;
                this.subtotal = '0.00';
                this.selectedSubtotal = '0.00';
            });
        },
        updateCartCounts() {
            if (!this.cart || !this.cart.items) {
                this.cartCount = 0;
                this.subtotal = '0.00';
                this.selectedSubtotal = '0.00';
                return;
            }
            
            this.cartCount = this.cart.items.reduce((sum, item) => sum + item.quantity, 0);
            this.subtotal = this.cart.items.reduce((sum, item) => sum + (item.book.price * item.quantity), 0).toFixed(2);
            this.selectedSubtotal = this.cart.items
                .filter(item => item.selected)
                .reduce((sum, item) => sum + (item.book.price * item.quantity), 0)
                .toFixed(2);
        },
        toggleItemSelection(itemId) {
            const item = this.cart.items.find(item => item.id === itemId);
            if (item && !item.isOutOfStock) {
                item.selected = !item.selected;
                this.updateCartCounts();
            }
        },
        get hasSelectedItems() {
            return this.cart && this.cart.items && this.cart.items.some(item => item.selected);
        },
        proceedToCheckout() {
            const selectedItems = this.cart.items.filter(item => item.selected);
            if (selectedItems.length === 0) return;

            // Check if profile is complete
            fetch('/check-profile-completion', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.isComplete) {
                    Swal.fire({
                        title: 'Complete Your Profile',
                        text: 'Please complete your profile before proceeding to checkout.',
                        icon: 'warning',
                        confirmButtonColor: '#6B46C1',
                        confirmButtonText: 'Complete Profile'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/customer/profile/setup';
                        }
                    });
                    return;
                }

                // Store selected items in session storage
                sessionStorage.setItem('checkoutItems', JSON.stringify(selectedItems));
                
                // Redirect to checkout page
                window.location.href = '/customers/order/order-checkout';
            })
            .catch(error => {
                console.error('Error checking profile completion:', error);
            });
        },
        updateQuantity(itemId, newQuantity) {
            if (newQuantity < 1) return;
            
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    this.fetchCart();
                } else {
                    throw new Error(data.error || 'Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
                alert('Failed to update quantity. Please try again.');
            });
        },
        removeItem(itemId) {
            Swal.fire({
                title: 'Remove Item',
                text: 'Are you sure you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6B46C1',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    
                    fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            this.fetchCart();
                            Swal.fire({
                                title: 'Removed!',
                                text: 'Item has been removed from your cart.',
                                icon: 'success',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        } else {
                            throw new Error(data.error || 'Failed to remove item');
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to remove item. Please try again.',
                            icon: 'error',
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    });
                }
            });
        }
    });
});
</script>