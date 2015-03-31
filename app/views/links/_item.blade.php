<a href="{{$app->urlFor('links.show', ['id' => $link->id])}}">Show</a> - 
<a href="{{$link->uri}}" target="_blank">{{$link->name}}</a>
({{$link->status->value}}) - 
<a href="{{$app->urlFor('links.edit', ['id' => $link->id])}}">Edit</a> - 
<a href="{{$app->urlFor('links.delete', ['id' => $link->id])}}">Delete</a>