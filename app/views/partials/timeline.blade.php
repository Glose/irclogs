<aside class="timeline">
	<ul>
		@foreach($timeline as $year => $months)
			<li>
				{{ $year }}
				<ul>
					@foreach($months as $month => $days)
						<li>
							{{ $month }}
							<ul>
								@foreach($days as $day)
									<li>{{ Html::linkAction('LogsController@getIndex', $day, array($year.'-'.$month.'-'.$day, '00:00')) }}</li>
								@endforeach
							</ul>
						</li>
					@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
</aside>
