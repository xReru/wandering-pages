<head>@vite('resources/css/app.css')</head>
@props([
    'title' => 'Buy the Complete Series for less',
    'originalPrice' => 73.50,
    'salePrice' => 43.50,
    'books' => [
        [
            'title' => 'Before the Darkest Hour',
            'author' => 'Brenna Harlow',
            'image' => 'images/before-the-darkest-hour.png',
            'rotate' => '-rotate-0'
        ],
        [
            'title' => 'Blood at Dusk',
            'author' => 'Brenna Harlow',
            'image' => 'images/blood-at-dusk.png',
            'rotate' => 'rotate-0'
        ],
        [
            'title' => 'Blood After Dawn',
            'author' => 'Brenna Harlow',
            'image' => 'images/blood-after-dawn.png',
            'rotate' => '-rotate-0'
        ],
        [
            'title' => 'Blood follows Midnight',
            'author' => 'Brenna Harlow',
            'image' => 'images/blood-follows-midnight.png',
            'rotate' => 'rotate-0'
        ],
        [
            'title' => 'Blood before Sunrise',
            'author' => 'Brenna Harlow',
            'image' => 'images/blood-before-sunrise.png',
            'rotate' => 'rotate-0'
        ],
    ],
    'buyNowUrl' => '#',
    'browseMoreUrl' => '#'
])

<section class="bg-gradient-to-r from-purple-100 via-purple-200 to-purple-400 py-12 px-4 sm:px-6 lg:px-8 font-['EBGaramond']">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between bg-purple-200/80 rounded-lg overflow-hidden shadow-lg">
            <!-- Left Section with Text and CTA -->
            <div class="p-6 md:p-8 lg:p-12 md:w-1/2 lg:w-2/5 flex flex-col justify-center h-full">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1B1146] mb-4 font-['EBGaramond']">{{ $title }}</h2>
                <div class="flex items-center mb-6 font-['EBGaramond']">
                    <p class="text-[#1B1146] line-through mr-3 text-lg font-['EBGaramond']">$ {{ number_format($originalPrice, 2) }}</p>
                    <p class="text-[#1B1146] font-bold text-xl sm:text-2xl font-['EBGaramond']">$ {{ number_format($salePrice, 2) }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 font-['EBGaramond']">
                    <a href="{{ $buyNowUrl }}" class="bg-[#7464B6] hover:bg-[#6354A0] text-white font-medium py-2 px-6 rounded transition duration-300 text-center">Buy Now</a>
                    <a href="{{ $browseMoreUrl }}" class="border border-[#7464B6] hover:border-[#6354A0] text-[#7464B6] font-medium py-2 px-6 rounded transition duration-300 text-center">Browse More</a>
                </div>
            </div>
            <!-- Right Section with Book Covers Fan/Slider -->
            <div class="p-4 md:w-1/2 lg:w-3/5 flex items-center justify-center min-h-[22rem] w-full">
                <div class="relative h-72 sm:h-80 md:h-96 w-full flex items-center justify-center" x-data="bookPromoFan({{ json_encode($books) }})" x-init="init()">
                    <template x-for="(book, index) in books" :key="index">
                        <div class="absolute transition-all duration-700 book-cover cursor-pointer" :style="getBookStyle(index)" @click="setActiveBook(index)">
                            <img :src="book.image.startsWith('http') ? book.image : '/'+book.image" :alt="book.title" class="h-64 sm:h-72 md:h-80 lg:h-96 w-40 sm:w-48 md:w-56 lg:w-60 rounded-lg shadow-xl border-2 border-white object-cover" style="font-family: 'EBGaramond', serif;">
                        </div>
                    </template>
                    <div class="absolute top-1/2 left-0 right-0 flex justify-between transform -translate-y-1/2 px-2 md:px-8 z-20">
                        <button @click="prevBook()" class="bg-white text-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 transition duration-300"><i class="fas fa-chevron-left"></i></button>
                        <button @click="nextBook()" class="bg-white text-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 transition duration-300"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function bookPromoFan(booksData) {
            return {
                activeIndex: 0,
                autoplayInterval: null,
                books: booksData,
                init() {
                    this.startAutoplay();
                },
                getBookStyle(index) {
                    const offset = (index - this.activeIndex + this.books.length) % this.books.length;
                    const zIndex = this.books.length - offset;
                    let translateX, opacity, scale;
                    if (offset === 0) {
                        translateX = '0%';
                        opacity = 1;
                        scale = 1;
                    } else {
                        translateX = `${20 * offset}%`;
                        opacity = 1;
                        scale = 1 - (offset * 0.05);
                    }
                    return `transform: translateX(${translateX}) scale(${scale}); z-index: ${zIndex}; opacity: ${opacity};`;
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
</section>