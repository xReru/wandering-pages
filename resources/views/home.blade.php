<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wandering Pages | Book Showcase</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap');

        @font-face {
            font-family: 'DancingScript';
            src: url('/fonts/DancingScript-Regular.ttf') format('truetype');
            font-weight: 400;
            /* Adjust as needed for different font weights */
            font-style: normal;
            /* Adjust as needed for different font styles */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f0f3;
        }

        .logo {
            font-family: 'DancingScript', regular;
            font-size: 2.2rem;
            font-weight: 700;
        }

        .book-title {
            font-family: 'Times New Roman', serif;
            font-weight: 700;
        }

        .carousel-control {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            font-size: 1.5rem;
        }

        .hero-section {
            background-color: #E6E9F2;
        }

        @media (max-width: 768px) {
            .book-container {
                flex-direction: column-reverse;
            }

            .book-info,
            .book-cover {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('subviews.banner')
</body>

</html>