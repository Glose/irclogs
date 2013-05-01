<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IRCLogs</title>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<link rel="stylesheet" href="app/css/styles.css">
</head>
<body>

	<header class="header">
		<h1 class="header-search" action="{{ URL::action('LogsController@search') }}" contenteditable placeholder="Laravel IRC logs" autofocus spellcheck="false" >
			Laravel IRC logs - Click to search
		</h1>
		<a class="logo" href="http://laravel.com">
			{{ Html::image('app/img/laravel.png', 'Laravel') }}
		</a>
	</header>

	<section class='content'>
		@yield('content')
	</section>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="app/js/scripts.js"></script>
</body>
</html>