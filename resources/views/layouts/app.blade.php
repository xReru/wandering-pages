<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Wandering Pages' }}</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
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
    </style>
</head>

<body class="h-full flex flex-col bg-white">

    <main class="flex-grow">
        @include('subviews.banner')
        @include('subviews.book-series')
        @include('subviews.book-series-showcase')
        @include('subviews.upcoming-book')
        @include('subviews.mini-book-browse')
    </main>
    @include('subviews.footer-section')
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
</body>

</html>