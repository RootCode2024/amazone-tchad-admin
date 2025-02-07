<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ env('APP_URL') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* Ajustement pour petits écrans */
        @media (max-width: 768px) {
            .wrapper {
                padding: 0 2px;
            }

            .body {
                padding: 1  px 0;
            }

            .container-lg {
                padding: 0 1px;
            }
        }

        /* Ajustement pour tablettes */
        @media (min-width: 769px) and (max-width: 1024px) {
            .container-lg {
                max-width: 90%;
            }
        }

        /* Optimisation pour grands écrans */
        @media (min-width: 1025px) {
            .container-lg {
                max-width: 80%;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/style.scss'])
    @vite(['resources/js/app.js'])
    @yield('head')


</head>

<body>

    @include('backend.layouts.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    @include('backend.layouts.components.top-header')

     <div class="body flex-grow-1 ">
        <div class="container-lg">
            @include('backend.layouts.components.response')

            <div class="content-wrapper pb-4">
                @yield('content')
            </div>
        </div>
    </div>

    @include('backend.layouts.components.footer')
</div>

    @vite(['resources/js/app.js'])
</body>

</html>
