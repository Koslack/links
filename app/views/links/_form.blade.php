@if(isset($flash['link.errors']))
	@foreach($flash['link.errors'] as $error)
		<div class="alert alert-warning" role="alert">{{$error}}</div>
	@endforeach
@endif

{{$form = \FormManager\Builder::form()}}
{{
	$form->attr([
	    'action' => isset($link) ? $app->urlFor('link.update', ['id' => $link->id]) : $app->urlFor('link.store'),
	    'method' => 'post'
	])->add([
	    'name' => FormManager\Builder::text()
	    	->addClass('form-control')
	    	->id('link_name')
	    	->placeholder('Name ej. twitter')
	    	->maxlength(128)
	    	->required()
	    	->label('Link Name')
	    	->val(isset($link) ? $link->name : ''),
	    'uri' => FormManager\Builder::text()
	    	->addClass('form-control')
	    	->id('link_uri')
	    	->placeholder('Uri ej. http://twitter.com')
	    	->maxlength(128)
	    	->required()
	    	->label('Link Uri')
	    	->val(isset($link) ? $link->uri : ''),
	    'status' => FormManager\Builder::select()
	    	->options([
		    	'' => '-- Choose a Status --',
				'favorite' => 'Favoritos',
				'important' => 'Importante',
				'great' => 'Genial'
		    ])
		    ->addClass('form-control')
		    ->id('link_status')
		    ->label('Link Status')
		    ->val(isset($link) ? $link->status : ''),
        'save' => FormManager\Builder::submit()->addClass('btn btn-primary pull-right')->html('Save Link')
	])->loadFromGlobals()
}}