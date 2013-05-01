@foreach ($logs as $log)
	@if (isset($search) && $search)
		<a href="/{{ $log->getUrl() }}" class="logs-nav">
			<li class="log-secondary"> 
				–– {{ $log->getDay() }}
			</li>
		</a>
	@endif
	<a href="/{{ $log->getUrl() }}" class="logs-nav">
		<li class="log-entry log-entry-{{ $log->type }}">
			<span class="log-entry-time">
				{{ $log->getHour() }}
			</span>
			{{ $log->getText() }}
		</li>
	</a>
@endforeach
