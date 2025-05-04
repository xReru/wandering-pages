<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoulBlood Series by Brenna Harlow</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .book-cover {
            transition: all 0.8s ease;
            transform-origin: center bottom;
        }

        .book-cover-container {
            perspective: 1000px;
        }
    </style>
</head>

<body class="bg-gray-200">
    <div class="container mx-auto px-4 py-12" x-data="bookShowcase()">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <!-- Text Content -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0 space-y-4">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Buy a Complete Series</h2>
                <p class="text-lg text-gray-800">SoulBlood Series by Brenna Harlow</p>
                <button
                    class="bg-[#5440AA] text-white font-medium py-2 px-8 rounded-md hover:bg-purple-800 transition duration-300">
                    $43.50
                </button>
            </div>

            <!-- Book Slider -->
            <div class="w-full md:w-2/3.5 relative h-90 md:h-96">
                <div class="book-cover-container p-20 relative h-full w-full">
                    <template x-for="(book, index) in books" :key="index">
                        <div class="book-cover absolute" :style="getBookStyle(index)" @click="setActiveBook(index)">
                            <img :src="book . image" :alt="book . title" class="h-64 md:h-80 rounded-md shadow-lg">
                        </div>
                    </template>
                </div>
                <div class="absolute top-1/2 left-0 right-0 flex justify-between transform -translate-y-1/2">
                    <button @click="prevBook()"
                        class="bg-white text-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 transition duration-300">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="nextBook()"
                        class="bg-white text-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 transition duration-300">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            function bookShowcase() {
                return {
                    activeIndex: 0,
                    autoplayInterval: null,
                    books: [
                        {
                            title: 'Before Darkest Hour',
                            image: '/images/before-the-darkest-hour.png'
                        },
                        {
                            title: 'Blood after Dawn',
                            image: '/images/blood-after-dawn.png'
                        },
                        {
                            title: 'Blood at Dusk',
                            image: '/images/blood-at-dusk.png'
                        },
                        {
                            title: 'Blood before Sunrise',
                            image: '/images/blood-before-sunrise.png'
                        },
                        {
                            title: 'Blood follows Midnight',
                            image: '/images/blood-follows-midnight.png'
                        }
                    ],

                    init() {
                        this.startAutoplay();
                    },

                    getBookStyle(index) {
                        const offset = (index - this.activeIndex + this.books.length) % this.books.length;
                        const zIndex = this.books.length - offset;
                        let translateX, translateY, rotate, opacity, scale;

                        if (offset === 0) {
                            // Active book
                            translateX = '0%';
                            translateY = '0%';
                            rotate = '0deg';
                            opacity = 1;
                            scale = 1;
                        } else {
                            // Other books
                            translateX = `${25 * offset}%`;
                            translateY = `${5 * offset}%`;
                            rotate = `${-5 + (offset * 3)}deg`;
                            opacity = 1 - (offset * 0.15);
                            scale = 1 - (offset * 0.05);
                        }

                        return `
                        transform: translateX(${translateX}) translateY(${translateY}) rotate(${rotate}) scale(${scale});
                        z-index: ${zIndex};
                        opacity: ${opacity};
                    `;
                    },

                    nextBook() {
                        this.activeIndex = (this.activeIndex + 1) % this.books.length;
                        this.restartAutoplay();
                    },

                    prevBook() {
                        this.activeIndex = (this.activeIndex - 1 + this.books.length) % this.books.length;
                        this.restartAutoplay();
                    },

                    setActiveBook(index) {
                        this.activeIndex = index;
                        this.restartAutoplay();
                    },

                    startAutoplay() {
                        this.autoplayInterval = setInterval(() => {
                            this.nextBook();
                        }, 3500);
                    },

                    restartAutoplay() {
                        clearInterval(this.autoplayInterval);
                        this.startAutoplay();
                    }
                };
            }
        </script>
</body>