<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel IRC logs</title>
	{{ Basset::show('application.css') }}
</head>
<body>

	<header class="header">
		<input name="search" value="{{ isset($search) ? $search : null }}" class="header-search" action="{{ URL::to('search/') }}" contenteditable placeholder="Laravel IRC logs" autofocus autocomplete="off" spellcheck="false">
		<a class="logo" href="http://laravel.com">
			{{ Html::image('app/img/laravel.png', 'Laravel') }}
		</a>
		<div class="links">
			Powered by <a href="http://glose.com">Glose</a> · <a href="http://github.com/Glose/irclogs" target="_blank">Fork us on Github</a>
		</div>
	</header>

	<section class='container'>
		<main class='content'>
			@yield('content')
		</main>
		<aside class='timeline'>
			@include('partials.timeline')
		</aside>
	</section>

	{{ Basset::show('application.js') }}
</body>
</html>