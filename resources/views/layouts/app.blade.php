<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Wandering Pages' }}</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <style>
        @font-face {
            font-family: 'DancingScript';
            src: url('/fonts/DancingScript-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'EBGaramond';
            src: url('/fonts/EBGaramond-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Heebo-Regular';
            src: url('/fonts/Heebo-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'DMSans';
            src: url('/fonts/DMSans-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body class="h-full flex flex-col !bg-[#F9F8FF]">
    @include('subviews.navbar-section')
    
    @if(Auth::guard('customer')->check() && (empty(Auth::guard('customer')->user()->first_name) || 
        empty(Auth::guard('customer')->user()->last_name) || 
        empty(Auth::guard('customer')->user()->phone_number) || 
        empty(Auth::guard('customer')->user()->address)))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-[60px]">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Please complete your profile to enjoy a better shopping experience. 
                    <a href="{{ route('customer.profile.setup') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">
                        Complete your profile now
                    </a>
                </p>
            </div>
        </div>
    </div>
    @endif
    <div 
  x-data="{ showButton: false }" 
  x-init="window.addEventListener('scroll', () => showButton = window.scrollY > 300)"
  class="fixed bottom-4 right-4"
>
  <button 
    x-show="showButton"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="bg-[#7464B6] text-white p-3 rounded-full shadow-lg hover:bg-[#6354A0] transition"
    aria-label="Scroll to top"
  >
    <i class="fas fa-arrow-up"></i>
  </button>
</div>

    <main class="flex-grow mt-[60px]">
        @yield('content')
    </main>
    @include('subviews.footer-section')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/js/splide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const splideElement = document.querySelector('.splide');
            if (splideElement) {
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
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>