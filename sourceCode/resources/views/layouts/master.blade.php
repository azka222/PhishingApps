<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.umd.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="{{ url('image/kittyoEat.png') }}" type="image/x-icon" />
</head>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ url('css/flowbite.min.css') }}">
<link rel="stylesheet" href="{{ url('css/app.css') }}">
<script src='{{ url('/js/app.js') }}'></script>
</head>

<body>
    <header>
        @include('layouts.header')
    </header>

    <main>

        @yield('content')
    </main>

    <footer>
        @include('layouts.footer')
    </footer>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('resources/js/app.js') }}"></script> --}}
</body>

</html>
