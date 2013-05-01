<ul>
	@foreach($timeline as $year => $months)
		<li class="timeline-year">
			<a href="#">{{ $year }}</a>
			<ul>
				@foreach($months as $month => $days)
					<li class="timeline-month">
						<a href="#">{{ Carbon::createFromDate(2012, $month)->format('F') }}</a>
						<ul>
							@foreach($days as $day => $date)
								@if (Str::contains(URL::full(), $date->format('Y-m-d')))
									<li class="timeline-day current">
								@else
									<li class="timeline-day">
								@endif
									<a href="{{ URL::to($date->format('Y-m-d')) }}">
										{{ $date->format('d l') }}
									</a>
								</li>
							@endforeach
						</ul>
					</li>
				@endforeach
			</ul>
		</li>
	@endforeach
</ul>
