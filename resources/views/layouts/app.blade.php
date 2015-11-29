<!DOCTYPE html>
<html>
<head>
    <title>Apartments List</title>
    @yield('head')
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <div class="container">
            @yield('content')
        </div>

        <script src="{{ elixir('js/app.js') }}"></script>
        @yield('footer')
    </div>
</body>
</html>
