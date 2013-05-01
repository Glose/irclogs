<ul>
	@foreach($timeline as $year => $months)
		<li>
			<a href="#">{{ $year }}</a>
			<ul>
				@foreach($months as $month => $days)
					<li>
						<a href="#">{{ $month }}</a>
						<ul>
							@foreach($days as $day => $date)
								@if (URL::full() == $date)
									<li class="current">
								@else
									<li>
								@endif
									<a href="{{ $date }}">
										{{ $year.'-'.$month.'-'.$day }}
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
