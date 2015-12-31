<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apartments List</title>
    @yield('head')
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        @include('common/_header')
        <div class="container">
            @yield('content')
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="{{ elixir('js/app.js') }}"></script>
        @yield('footer')
    </div>
</body>
</html>
