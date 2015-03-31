@if(isset($flash['link.errors']))
	@foreach($flash['link.errors'] as $error)
		<div class="alert alert-warning" role="alert">{{$error}}</div>
	@endforeach
@endif

<form action="{{$app->urlFor('links.store')}}" method="POST" role="form">
	<legend>Add new link</legend>
	<div class="form-group">
		<label for="">Link Name</label>
		<input type="text" class="form-control" id="link_name" name="name" placeholder="Name ej. twitter">
		<label for="">Link url</label>
		<input type="text" class="form-control" id="link_url" name="uri" placeholder="Uri ej. http://twitter.com">
		<label for="">Link status</label>
		<select type="text" class="form-control" id="link_status" name="status_code" placeholder="Link Status">
			<option selected="selected" value="">-- Choose a Status --</option>
			@foreach($link_statuses as $link_status)
				<option value="{{$link_status->code}}">{{ucfirst($link_status->value)}}</option>
			@endforeach
		</select>
	</div>

	<button type="submit" class="btn btn-primary pull-right">Save Link</button>
</form>