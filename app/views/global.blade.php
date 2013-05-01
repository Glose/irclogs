<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IRCLogs</title>
	<link rel="stylesheet" href="{{ URL::asset('app/css/styles.css') }}">
</head>
<body>

	<header class="header">
		<input class="header-search" action="{{ URL::action('LogsController@search') }}" contenteditable placeholder="Laravel IRC logs" autofocus spellcheck="false">
		<a class="logo" href="http://laravel.com">
			{{ Html::image('app/img/laravel.png', 'Laravel') }}
		</a>
	</header>

	<section class='content'>
		@yield('content')
	</section>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="components/linkify/jquery.linkify.js"></script>
	<script src="{{ URL::asset('app/js/scripts.js') }}"></script>
</body>
</html>