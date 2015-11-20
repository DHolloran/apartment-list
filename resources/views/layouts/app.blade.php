<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<div class="container">
		@yield('content')
	</div>
	<script src="{{ elixir('js/app.js') }}" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>
