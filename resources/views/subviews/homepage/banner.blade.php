@if($bannerSlides->isNotEmpty())
<!-- Hero Section with Book Showcase -->
<section class="hero-section">
    <div class="container mx-auto px-4 py-12">
        <!-- Splide Carousel -->
        <div class="splide" role="group" aria-label="Featured Books">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($bannerSlides as $slide)
                        @if($slide->book)
                            <li class="splide__slide">
                                <div class="flex book-container items-center justify-between px-8 md:px-16">
                                    <!-- Book Information -->
                                    <div class="book-info w-full md:w-1/2 pr-0 md:pr-8">
                                        <div class="mb-6">
                                            <p class="text-xs uppercase tracking-widest text-indigo-800 font-medium mb-2">
                                                {{ strtoupper(str_replace('_', ' ', $slide->type)) }}
                                            </p>
                                            <h1 class="book-title text-5xl md:text-6xl mb-2">{{ $slide->book->title }}</h1>
                                            <p class="book-author text-indigo-800 mb-6">{{ $slide->book->author }}</p>
                                            <p class="text-gray-700 mb-8 text-sm">
                                                {{ $slide->book->description }}
                                            </p>
                                            <div class="flex space-x-3">
                                                <a href="{{ route('books.show', $slide->book) }}" 
                                                   class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 py-2 rounded text-sm font-medium">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Book Cover -->
                                    <div class="book-cover w-full md:w-1/2 flex justify-center">
                                        <img src="{{ Storage::url($slide->book->image) ?? '/api/placeholder/320/480' }}" 
                                             alt="{{ $slide->book->title }} Book Cover"
                                             class="h-auto max-w-full rounded-lg shadow-lg" 
                                             width="350" 
                                             height="500"
                                             onerror="this.src='/api/placeholder/320/480';this.onerror='';">
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('.splide', {
            type: 'fade',
            perPage: 1,
            perMove: 1,
            gap: '1rem',
            rewind: true,
            pagination: false,
            arrows: true,
            autoplay: true,
            interval: 3000,
            pauseOnHover: true,
            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
            breakpoints: {
                640: {
                    arrows: false,
                }
            }
        }).mount();
    });
</script>