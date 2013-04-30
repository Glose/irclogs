@extends('global')

@section('content')
	<ul class="unstyled logs">
		@foreach ($logs as $log)
			<li class="log-entry log-entry-{{ $log->type }}">
				{{ $log->getHour() }}
				{{ $log->getText() }}
			</li>
		@endforeach
	</ul>
@stop