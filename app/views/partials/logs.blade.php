@if (isset($moreup))
	<a href="/infinite/up/{{ $moreup }}" class="infinite-more-link-up"></a>
@endif
@foreach ($logs as $log)
	<a href="/{{ $log->getUrl() }}" class="logs-nav">
		@if (isset($search) && $search)
			<li class="log-secondary">
				–– {{ $log->getDay() }}
			</li>
		@endif
		<li class="log-entry log-entry-{{ $log->type }}" data-url="{{ $log->getUrl() }}" id="log-{{ $log->_id }}">
			<span class="log-entry-time">
				{{ $log->getHour() }}
			</span>
			{{ $log->getText() }}
		</li>
	</a>
@endforeach
@if (isset($moredown))
	<a href="/infinite/down/{{ $moredown }}" class="infinite-more-link-down"></a>
@endif
