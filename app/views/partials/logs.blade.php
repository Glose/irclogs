@foreach ($logs as $log)
	@if (isset($search) && $search)
		<a href="/{{ $log->getUrl() }}" class="logs-nav">
			<li class="log-secondary"> 
				–– {{ $log->getDay() }}
			</li>
			<li class="log-entry log-entry-{{ $log->type }}">
				<span class="log-entry-time">
					{{ $log->getHour() }}
				</span>
				{{ $log->getText() }}
			</li>
		</a>
	@else
		<li class="log-entry log-entry-{{ $log->type }}" data-url="{{ $log->getUrl() }}" id="log-{{ $log->_id }}">
			<span class="log-entry-time">
				{{ $log->getHour() }}
			</span>
			{{ $log->getText() }}
		</li>
	@endif
@endforeach
