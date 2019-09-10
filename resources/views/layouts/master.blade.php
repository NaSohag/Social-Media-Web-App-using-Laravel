<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('src/custom.css') }}">
</head>
<body>
	@include('includes.header')
	<div class="container">
		@include('includes.message')
	</div>
	
	<div class="container">
		@yield('content')
	</div>
	
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('src/custom.js') }}"></script>
</body>
</html>