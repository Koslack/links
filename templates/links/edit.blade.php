@extends('layouts.main')

@section('content')
	<h1>Edit - {{$link->name}}</h1>
	<a href="{{$app->urlFor('links.index')}}">Index links</a>
	@include('links._form')
@stop