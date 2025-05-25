<head>@vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
</head>
<header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-[100]" x-data="{ mobileMenuOpen: false, showUserModal: false, searchQuery: '', searchResults: [], isSearching: false, showResults: false, searchError: null, mobileSearchOpen: false }" x-init="$store.cart.init()">
    <div class="container mx-auto px-4 py-3">
        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
             @click="mobileMenuOpen = false"
             style="display: none;">
        </div>

        <!-- Mobile Menu Sidebar -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 bottom-0 w-64 bg-white shadow-lg z-50 md:hidden"
             style="display: none;">
            <div class="p-4 border-b border-gray-200">
                <button @click="mobileMenuOpen = false" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="flex flex-col">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 px-4 py-4" @click="mobileMenuOpen = false">Home</a>
                <a href="{{ route('browse-books') }}" class="text-gray-700 hover:text-gray-900 px-4 py-4" @click="mobileMenuOpen = false">Shop</a>
                <a href="{{ route('contact-us') }}" class="text-gray-700 hover:text-gray-900 px-4 py-4" @click="mobileMenuOpen = false">Contact</a>
            </nav>
        </div>

        <div class="flex items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 hover:text-gray-900 focus:outline-none mr-4">
                    <i class="fas text-xl" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo text-gray-800 md:mr-6">Wandering Pages</a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="px-6 py-2 text-gray-700 hover:text-gray-900 mx-1">Home</a>
                    <a href="{{ route('browse-books') }}" class="px-6 py-2 text-gray-700 hover:text-gray-900 mx-1">Shop</a>
                    <a href="{{ route('contact-us') }}" class="px-6 py-2 text-gray-700 hover:text-gray-900 mx-1">Contact</a>
                </nav>
            </div>

            <!-- Search, Cart and Account -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Search Button -->
                <button @click="mobileSearchOpen = true" class="md:hidden text-gray-700 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-search text-xl"></i>
                </button>

                <!-- Desktop Search -->
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
                                    <div class="font-primary text-md font-semibold text-[#1B1146]" x-text="book.title"></div>
                                    <div class="font-secondary text-sm text-[#1B1146] font-regular" x-text="book.author"></div>
                                    <div class="font-secondary text-sm font-medium text-[#6354A0]">$ <span class="font-secondary text-sm font-medium text-[#6354A0]" x-text="book.price"></span></div>
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

                <!-- Mobile Search Modal -->
                <div x-show="mobileSearchOpen" 
                     class="fixed inset-0 z-50 md:hidden"
                     @click.away="mobileSearchOpen = false"
                     style="display: none;">
                    <!-- Backdrop with blur -->
                    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40"></div>
                    
                    <!-- Modal Content -->
                    <div class="fixed left-0 right-0 top-0 w-full bg-white shadow-lg rounded-b-2xl transform transition-all duration-300 ease-in-out z-50"
                         :class="mobileSearchOpen ? 'translate-y-0' : '-translate-y-full'">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-primary text-lg font-semibold text-[#1B1146]">Search Books</h3>
                                <button @click="mobileSearchOpen = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <div class="relative">
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" 
                                       placeholder="Search books...">
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            
                            <!-- Mobile Search Results -->
                            <div class="mt-4 max-h-[calc(100vh-200px)] overflow-y-auto">
                                <template x-if="isSearching">
                                    <div class="flex items-center justify-center py-8">
                                        <i class="fas fa-spinner fa-spin text-purple-600 text-xl"></i>
                                        <span class="ml-3 text-gray-600">Searching...</span>
                                    </div>
                                </template>
                                
                                <template x-if="searchError">
                                    <div class="flex items-center justify-center py-8 text-red-600">
                                        <i class="fas fa-exclamation-circle text-xl"></i>
                                        <span class="ml-3" x-text="searchError"></span>
                                    </div>
                                </template>
                                
                                <template x-if="showResults && !isSearching && !searchError && searchResults.length === 0">
                                    <div class="text-center py-8 text-gray-600">
                                        <i class="fas fa-search text-2xl mb-2"></i>
                                        <p>No books found</p>
                                    </div>
                                </template>
                                
                                <template x-for="book in searchResults" :key="book.id">
                                    <a :href="'/books/' + book.id" 
                                       @click="mobileSearchOpen = false"
                                       class="flex items-center p-4 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                        <img :src="book.image_url" class="w-16 h-20 object-cover rounded-lg shadow-sm mr-4" :alt="book.title">
                                        <div class="flex-1 min-w-0">
                                            <div class="font-primary font-medium text-[#1B1146] truncate" x-text="book.title"></div>
                                            <div class="text-sm text-gray-600" x-text="book.author"></div>
                                            <div class="text-sm font-medium text-[#6354A0] mt-1">$ <span x-text="book.price" class="font-secondary text-sm font-medium text-[#6354A0]"></span></div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::guard('customer')->check())
                <div class="flex items-center">
                    <span class="text-[#6354A0] font-normal font-medium mr-1">$ <span x-text="$store.cart.subtotal">0.00</span></span>
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
<div x-show="$store.cart.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50" 
     style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/70" @click="$store.cart.open = false"></div>
    
    <!-- Cart Content -->
    <div class="fixed inset-y-0 right-0 w-full max-w-md transform transition-transform duration-300 ease-in-out"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full">
        <div class="h-full bg-white shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="font-normal text-2xl font-bold text-gray-900">Shopping Cart</h2>
                <button @click="$store.cart.open = false" 
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                <template x-if="$store.cart.cart && $store.cart.cart.items && $store.cart.cart.items.length">
                    <div class="space-y-4">
                        <template x-for="item in $store.cart.cart.items" :key="item.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start space-x-4">
                                    <input type="checkbox"
                                        :checked="item.selected"
                                        @change="!item.isOutOfStock && !item.isArchived && $store.cart.toggleItemSelection(item.id)"
                                        :disabled="item.isOutOfStock || item.isArchived"
                                        class="mt-2 h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer transition"
                                        :class="{'opacity-50 cursor-not-allowed': item.isOutOfStock || item.isArchived}">
                                    
                                    <img :src="item.book.image_url" 
                                         class="h-24 w-16 object-cover rounded-lg shadow-sm border" 
                                         :alt="item.book.title">
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="relative inline-block">
                                                    <h3 class="font-normal text-lg font-semibold text-gray-900 truncate" 
                                                        x-text="item.book.title.length > 26 ? item.book.title.substring(0, 26) + '...' : item.book.title"
                                                        x-data="{ tooltip: false }"
                                                        @mouseenter="tooltip = true"
                                                        @mouseleave="tooltip = false">
                                                    </h3>
                                                    <div x-show="tooltip && item.book.title.length > 26"
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease-in duration-150"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="absolute z-[9999] px-3 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-lg whitespace-normal max-w-xs -top-2 left-1/2 transform -translate-x-1/2 -translate-y-full pointer-events-none">
                                                        <span x-text="item.book.title"></span>
                                                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-2 h-2 bg-gray-900"></div>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1" x-text="item.book.author"></p>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <template x-if="item.isArchived">
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">UNAVAILABLE</span>
                                                </template>
                                                <template x-if="!item.isArchived && item.isOutOfStock">
                                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">OUT OF STOCK</span>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full text-gray-600 font-bold transition-colors"
                                                    :disabled="item.quantity <= 1">-</button>
                                                <span x-text="item.quantity" class="w-8 text-center font-medium text-gray-900"></span>
                                                <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)"
                                                    :disabled="item.isArchived || item.isOutOfStock" class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full text-gray-600 font-bold transition-colors">+</button>
                                            </div>
                                            
                                            <div class="flex items-center space-x-4">
                                                <span class="text-lg font-semibold text-[#6354A0]">
                                                    $ <span x-text="(item.book.price * item.quantity).toFixed(2)"></span>
                                                </span>
                                                <button @click="$store.cart.removeItem(item.id)"
                                                    class="text-gray-400 hover:text-[#6354A0] transition-colors"
                                                    title="Remove from cart">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Empty Cart State -->
                <template x-if="!$store.cart.cart || !$store.cart.cart.items || $store.cart.cart.items.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 mb-6">Add some books to your cart to start shopping</p>
                        <a href="{{ route('browse-books') }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                            Browse Books
                        </a>
                    </div>
                </template>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 p-6 bg-gray-50">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-lg font-semibold text-gray-900">Selected Items Subtotal:</span>
                    <span class="text-2xl font-bold text-[#6354A0]">$ <span x-text="$store.cart.selectedSubtotal"></span></span>
                </div>
                <button class="font-normal w-full bg-[#7464B6] hover:bg-[#6354A0] text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        @click.prevent="$store.cart.proceedToCheckout()"
                        :disabled="!$store.cart.hasSelectedItems">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>
</div>
@endif
            </div>
        </div>
    </div>
</header>
<script>
document.addEventListener('alpine:init', () => {
    // Add tooltip directive
    Alpine.directive('tooltip', (el, { expression }) => {
        if (!expression) return;
        
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute z-[200] px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg opacity-0 transition-opacity duration-200 pointer-events-none whitespace-normal max-w-xs';
        tooltip.style.bottom = '100%';
        tooltip.style.left = '50%';
        tooltip.style.transform = 'translateX(-50%)';
        tooltip.style.marginBottom = '5px';
        
        el.style.position = 'relative';
        el.appendChild(tooltip);
        
        el.addEventListener('mouseenter', () => {
            tooltip.textContent = expression;
            tooltip.style.opacity = '1';
        });
        
        el.addEventListener('mouseleave', () => {
            tooltip.style.opacity = '0';
        });
    });

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