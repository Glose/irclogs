{{-- Infinite-scroll up link --}}
@if (isset($moreup))
	<a href="/infinite/up/{{ $moreup }}" class="infinite-more-link-up"></a>
@endif

{{-------------------------------- Log entry --------------------------------}}

@foreach ($logs as $log)

	{{-- Date and day --}}
	@if (!isset($lastLog) || $lastLog->getCarbon()->day != $log->getCarbon()->day)
		<li class='logs-day'>{{ $log->getDay() }}</li>
	@endif
	<?php $lastLog = $log ?>

	{{-- The log entry --}}
	<a href="/{{ $log->getUrl() }}" class="logs-nav">

		{{-- Entry username, hour and message --}}
		<li class="log-entry new-log log-entry-{{ $log->type }}" data-url="{{ $log->getUrl() }}" id="log-{{ $log->_id }}">
			<span class="log-entry-time">
				{{ $log->getHour() }}
			</span>
			{{ $log->getText() }}
		</li>
	</a>
@endforeach

{{-- Infinite-scroll down link --}}
@if (isset($moredown))
	<a href="/infinite/down/{{ $moredown }}" class="infinite-more-link-down"></a>
@endif
