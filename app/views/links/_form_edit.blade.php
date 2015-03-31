@if(isset($flash['link.errors']))
	@foreach($flash['link.errors'] as $error)
		<div class="alert alert-warning" role="alert">{{$error}}</div>
	@endforeach
@endif

<form action="{{$app->urlFor('links.update', ['id' => $link->id])}}" method="POST" role="form">
	<legend>Edit link</legend>
	<div class="form-group">
		<label for="">Link Name</label>
		<input type="text" class="form-control" id="link_name" name="name" placeholder="Name ej. twitter" value="{{$link->name}}">

		<label for="">Link url</label>
		<input type="text" class="form-control" id="link_url" name="uri" placeholder="Uri ej. http://twitter.com" value="{{$link->uri}}">

		<label for="">Link status</label>
		<select type="text" class="form-control" id="link_status" name="status_code" placeholder="Link Status">
			<option selected="selected" value="">-- Choose a Status --</option>
			@foreach($link_statuses as $link_status)
				@if($link_status->code == $link->status->code)
					<option value="{{$link_status->code}}" selected="selected">{{ucfirst($link_status->value)}}</option>
				@else
					<option value="{{$link_status->code}}">{{ucfirst($link_status->value)}}</option>
				@endif
			@endforeach
		</select>
	</div>
	<button type="submit" class="btn btn-primary pull-right">Submit Link</button>
</form>