<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IRCLogs</title>
	<link rel="stylesheet" href="{{ URL::asset('components/normalize-css/normalize.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('app/css/styles.css') }}">
</head>
<body>

	<header class="header">
		<input class="header-search" action="{{ URL::to('search/') }}" contenteditable placeholder="Laravel IRC logs" autofocus spellcheck="false">
		<a class="logo" href="http://laravel.com">
			{{ Html::image('app/img/laravel.png', 'Laravel') }}
		</a>
	</header>

	<section class='container'>
		<main class='content'>
			@yield('content')
		</main>
		<aside class='timeline'>
			@include('partials.timeline')
		</aside>
	</section>


	<script src="{{ URL::asset('components/jquery/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('components/linkify/jquery.linkify.js') }}"></script>
	<script src="{{ URL::asset('app/js/scripts.js') }}"></script>
</body>
</html>