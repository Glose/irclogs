@foreach ($logs as $log)
	@if (isset($search) && $search)
		<li class="log-secondary"> 
			–– {{ $log->getDay() }}
		</li>
	@endif
	<li class="log-entry log-entry-{{ $log->type }}">
		<span class="log-entry-time">
			{{ $log->getHour() }}
		</span>
		{{ $log->getText() }}
	</li>
@endforeach
