<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
</head>
<body>
    <header>
        {{-- @include('partials.header') --}}
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        {{-- @include('partials.footer') --}}
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    

    
</body>
</html>