<head>@vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">

</head>
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="#" class="logo text-gray-800">Wandering Pages</a>
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="/browse-books" class="text-gray-700 hover:text-gray-900">Shop</a>
                    <a href="/contact-us" class="text-gray-700 hover:text-gray-900">Contact</a>
                </nav>
            </div>

            <!-- Search, Cart and Account -->
            <div class="flex items-center space-x-4" x-data="{ showUserModal: false }" x-init="$store.cart.init()">
                <div class="relative w-48 hidden md:block">
                    <input type="text" class="w-full px-4 py-1 border rounded-md" placeholder="Search...">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </button>
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
                    <div class="bg-white w-96 p-6 shadow-lg h-full overflow-y-auto relative">
                        <button @click="$store.cart.open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
                        <h2 class="text-xl font-bold mb-4">Shopping Cart</h2>
                        <template x-if="$store.cart.cart && $store.cart.cart.items && $store.cart.cart.items.length">
                            <div>
                                <template x-for="item in $store.cart.cart.items" :key="item.id">
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" 
                                               :checked="item.selected" 
                                               @change="!item.isOutOfStock && $store.cart.toggleItemSelection(item.id)"
                                               :disabled="item.isOutOfStock"
                                               class="mr-2 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer"
                                               :class="{'opacity-50 cursor-not-allowed': item.isOutOfStock}">
                                        <img :src="item.book.image_url" class="h-16 w-12 object-cover mr-2" alt="Book Cover">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <span x-text="item.book.title"></span>
                                                <span x-show="item.isOutOfStock" class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded">OUT OF STOCK</span>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)" 
                                                        class="bg-gray-200 px-2 py-1 rounded text-sm"
                                                        :disabled="item.quantity <= 1">-</button>
                                                <span x-text="item.quantity" class="w-8 text-center"></span>
                                                <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)" 
                                                        class="bg-gray-200 px-2 py-1 rounded text-sm">+</button>
                                                <button @click="$store.cart.removeItem(item.id)" 
                                                        class="ml-2 text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                $<span x-text="(item.book.price * item.quantity).toFixed(2)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="mt-4 font-bold">Selected Items Subtotal: $<span x-text="$store.cart.selectedSubtotal"></span></div>
                                <button class="mt-6 w-full bg-purple-700 text-white py-2 rounded font-bold hover:bg-purple-800 transition" 
                                        @click.prevent="$store.cart.proceedToCheckout()"
                                        :disabled="!$store.cart.hasSelectedItems">CHECKOUT</button>
                            </div>
                        </template>
                        <template x-if="!$store.cart.cart || !$store.cart.cart.items || $store.cart.cart.items.length === 0">
                            <div class="text-gray-500">Your cart is empty.</div>
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
                        // Check if item is out of stock based on quantity or is_active
                        item.isOutOfStock = item.quantity <= 0 || item.book.is_active === 0;
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

            // Store selected items in session storage
            sessionStorage.setItem('checkoutItems', JSON.stringify(selectedItems));
            
            // Redirect to checkout page
            window.location.href = '/customers/order/order-checkout';
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