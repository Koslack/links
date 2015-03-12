@extends('layouts.main')

@section('content')
	<ul>
		@foreach($links as $link)
			<li>
				@include('links._item', compact('link'))
			</li>
		@endforeach
	</ul>
@stop