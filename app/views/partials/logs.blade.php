<ul class="logs" data-first-log="{{ isset($firstLog) ? "#log-$firstLog->_id" : '' }}">
	<a href="#" class="infinite-more-link-up"></a>
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
	<a href="#" class="infinite-more-link-down"></a>
</ul>
