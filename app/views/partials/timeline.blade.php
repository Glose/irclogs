<aside class="timeline">
	@foreach($logs as $log)
		{{ $log->getDateTime()->format('Y-m-d') }}<br>
	@endforeach
</aside>
