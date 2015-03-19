@extends('layouts.main')

@section('content')
	<a href="{{$app->urlFor('links.index')}}">List Links</a>
	<br />
	@include('links._item', compact('link'))
@stop