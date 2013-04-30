@extends('global')

@section('content')
	@foreach ($logs as $log)
		{{ $log->type }} - {{ $log->nick }} : {{ $log->text }}<br>
	@endforeach
@stop