@extends('layouts.main')

@section('content')
	<a href="{{$app->urlFor('link.create')}}">Create link</a>
	<ul>
		@foreach($links as $link)
			<li>
				@include('links._item', compact('link'))
			</li>
		@endforeach
	</ul>
@stop