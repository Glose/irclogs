<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IRCLogs</title>
		<link href="http://fonts.googleapis.com/css?family=Ubuntu+Mono:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<link rel="stylesheet" href="app/css/styles.css">
</head>
<body>
	<header placeholder="Laralog" autofocus spellcheck="false" class='header' action="{{ URL::action('LogsController@search') }}" contenteditable>
		<h1>
			Laralog - Click to search
		</h1>
	</header>
	<section class='content'>
		@yield('content')
	</section>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="app/js/scripts.js"></script>
</body>
</html>