@extends('global')

@section('content')
	<ul class="unstyled logs">
		@foreach ($logs as $log)
			<li class="log-entry log-entry-{{ $log->type }}">
				<span class="log-entry-time">
					@if (isset($search) && $search)
						{{ $log->getDay() }} –
					@endif
					{{ $log->getHour() }}
				</span>
				{{ $log->getText() }}
			</li>
		@endforeach
	</ul>
@stop