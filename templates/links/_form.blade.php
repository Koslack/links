@if(isset($link))
	<form action="{{$app->urlFor('link.update', ['id' => $link->id])}}" method="POST" role="form">
		<legend>Edit link</legend>
@else
	<form action="{{$app->urlFor('link.store')}}" method="POST" role="form">
		<legend>Add new link</legend>
@endif
		

		<div class="form-group">
			<label for="">Link Name</label>
			<input type="text" class="form-control" id="link_name" name="name" placeholder="Link Name" value="@if(isset($link)){{$link->name}}@endif">
			<label for="">Link url</label>
			<input type="text" class="form-control" id="link_url" name="url" placeholder="Link Url" value="@if(isset($link)){{$link->url}}@endif">
			<label for="">Link status</label>
			<input type="text" class="form-control" id="link_status" name="status" placeholder="Link Status" value="@if(isset($link)){{$link->status}}@endif">
		</div>

		<button type="submit" class="btn btn-primary pull-right">Submit Link</button>
	</form>