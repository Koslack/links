@extends('layouts.main')

@section('content')
	<h1>Edit - {{$link->name}}</h1>
	@include('links._form')
@stop