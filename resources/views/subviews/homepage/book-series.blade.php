<head>@vite('resources/css/app.css')</head>
<style>
    .paused {
        animation-play-state: paused;
    }
    .book-card:nth-child(1) { animation-delay: 0.1s; }
    .book-card:nth-child(2) { animation-delay: 0.3s; }
    .book-card:nth-child(3) { animation-delay: 0.5s; }
</style>
</head>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                animation: {
                    'fade-in-up': 'fadeInUp 0.8s forwards'
                },
                keyframes: {
                    fadeInUp: {
                        '0%': { opacity: '0', transform: 'translateY(20px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' }
                    }
                }
            }
        }
    }
</script>
<body class="bg-gray-100">
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <p class="text-gray-500 mb-1">Complete Series Of</p>
        <h1 class="book-title text-4xl font-bold mb-1 text-gray-900">GrishaVerse Series</h1>
        <p class="text-gray-500 text-sm">Original series of Leigh Bardugo</p>
    </div>

    <!-- Book Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <!-- Shadow and Bone -->
        <div class="book-card bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 ease-in-out opacity-0 animate-fade-in-up paused hover:shadow-xl hover:-translate-y-2">
            <div class="relative h-90 overflow-hidden">
                <img src="{{ asset('images/shadow-and-bone.png') }}" alt="Shadow and Bone" class="w-full h-full object-contain max-h-[500px] transition-transform duration-500 ease-in-out group-hover:scale-105">
            </div>
            <div class="p-4">
                <p class="text-gray-500 text-sm mb-1">Fantasy</p>
                <h3 class="bs-title text-xl font-bold mb-1 text-gray-800">Shadow and Bone</h3>
                <p class="font-bold text-gray-700 mb-2">$24.00</p>
            </div>
        </div>

        <!-- Siege and Storm -->
        <div class="book-card bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 ease-in-out opacity-0 animate-fade-in-up paused hover:shadow-xl hover:-translate-y-2">
            <div class="relative h-90 overflow-hidden">
                <img src="{{ asset('images/siege-and-storm.png') }}" alt="Siege and Storm" class="w-full h-full object-contain max-h-[500px] transition-transform duration-500 ease-in-out group-hover:scale-105">
            </div>
            <div class="p-4">
                <p class="text-gray-500 text-sm mb-1">Fantasy</p>
                <h3 class="bs-title text-xl font-bold mb-1 text-gray-800">Siege and Storm</h3>
                <p class="font-bold text-gray-700 mb-2">$24.00</p>
            </div>
        </div>

        <!-- Ruin and Rising -->
        <div class="book-card bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 ease-in-out opacity-0 animate-fade-in-up paused hover:shadow-xl hover:-translate-y-2">
            <div class="relative h-90 overflow-hidden">
                <img src="{{ asset('images/ruin-and-rising.png') }}" alt="Ruin and Rising" class="w-full h-full object-contain max-h-[500px] transition-transform duration-500 ease-in-out group-hover:scale-105">
            </div>
            <div class="p-4">
                <p class="text-gray-500 text-sm mb-1">Fantasy</p>
                <h3 class="bs-title text-xl font-bold mb-1 text-gray-800">Ruin and Rising</h3>
                <p class="font-bold text-gray-700 mb-2">$24.00</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show cart button on hover
        const bookCards = document.querySelectorAll('.book-card');
        
        bookCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const cartBtn = this.querySelector('.add-to-cart');
                cartBtn.classList.remove('opacity-0', 'scale-90');
                cartBtn.classList.add('opacity-100', 'scale-100');
            });
            
            card.addEventListener('mouseleave', function() {
                const cartBtn = this.querySelector('.add-to-cart');
                cartBtn.classList.add('opacity-0', 'scale-90');
                cartBtn.classList.remove('opacity-100', 'scale-100');
            });
        });

        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('paused');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        bookCards.forEach(card => {
            observer.observe(card);
        });

        // Add to cart functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const bookCard = this.closest('.book-card');
                const bookTitle = bookCard.querySelector('h3').textContent;
                // You should ideally have a data-book-id attribute for each book card. For now, we'll use a lookup if available.
                // For demonstration, let's assume you have a JS object mapping titles to IDs:
                const bookIdMap = {
                    'Shadow and Bone': 1,
                    'Siege and Storm': 2,
                    'Ruin and Rising': 3
                };
                const bookId = bookIdMap[bookTitle];
                if (!bookId) return alert('Book ID not found for ' + bookTitle);
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ book_id: bookId, quantity: 1 })
                }).then(res => res.json()).then(data => {
                    if (window.cartModal) {
                        window.cartModal().fetchCart();
                    }
                });
                // Feedback animation
                this.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-shopping-cart text-gray-700"></i>';
                }, 1500);
            });
        });

        // Favorite button functionality
        const favoriteButtons = document.querySelectorAll('.favorite-btn');
        favoriteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-red-500');
                } else {
                    icon.classList.remove('fas', 'text-red-500');
                    icon.classList.add('far');
                }
            });
        });
    });
</script>