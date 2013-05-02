@extends('global')

@section('content')
	<ul class="logs" data-first-log="{{ isset($firstLog) ? "#log-$firstLog->_id" : '' }}">
		@include('partials.logs')
	</ul>
@stop
