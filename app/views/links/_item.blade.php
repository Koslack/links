<a href="{{$app->urlFor('link.show', ['id' => $link->id])}}">Show</a> - 
<a href="{{$link->uri}}" target="_blank">{{$link->name}}</a>
({{$link->status}}) - 
<a href="{{$app->urlFor('link.edit', ['id' => $link->id])}}">Edit</a> - 
<a href="{{$app->urlFor('link.delete', ['id' => $link->id])}}">Delete</a>