<?php
namespace App;

use Slim\Slim as Slim;
use Slim\Middleware\SessionCookie as SessionCookie;
use Slim\Views\Blade as Blade;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface as NestedValidationExceptionInterface;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware as WhoopsMiddleware;

use \App\Models\Link as Link;
use \App\Models\Lookup as Lookup;

class LinkManager{

	protected $app;

	public function __construct(){
		$this->app = new Slim([
			'view' => new Blade(),
			'templates.path' => '../app/views'
		]);
		$this->app->add(new WhoopsMiddleware);
		$this->app->add(new SessionCookie());

		$views = $this->app->view();
		$views->parserOptions = [
			'debug' => true,
			'cache' => '../html_cache'
		];

		$capsule = new Capsule; 

		$capsule->addConnection([
		    'driver'    => 'sqlite',
		    'database'  => __DIR__.'/store/app.sqlite.db',
		    'prefix'   => '',
		]);

		$capsule->bootEloquent();

		# Redirects to /links route
		$this->app->get('/', function(){
			$this->app->redirect('/links', 301);
		});

		# Defines a notFound error page
		$this->app->notFound(function(){
		    $this->app->render('errors.404');
		});
	}

	public function init(){
		# Redirects to /links route
		$this->app->get('/links', function(){
			$links = $this->getLinks();
			$this->app->render('links.index', ['links' => $links, 'app' => $this->app]);
		})
		->name('links.index');

		# Defines /links/create/ route to show a form for link creation
		$this->app->get('/links/create', function(){
			$link_statuses = $this->getStatuses('link.status');
			$this->app->render('links.create', ['app' => $this->app, 'link_statuses' => $link_statuses]);
		})
		->name('links.create');

		# Defines /links POST route that handles the received data from the creation form and stores it
		$this->app->post('/links', function(){
			$params = $this->app->request->post();
			unset($params['save']);
			$link = $this->storeLink($params);
			dd($link);
			if($link)
				$this->app->redirect('/links/' . $link->id);
			else
				$this->app->redirect('/links/create');
		})
		->name('links.store');

		# Defines /links/:id for showing a single link
		$this->app->get('/links/:id', function($id){
			$link = $this->getLink($id);
			$this->app->render('links.show', ['link' => $link, 'app' => $this->app]);
		})
		->name('links.show')
		->conditions(['id' => '[0-9]+']);

		# Defines /links/:id/edit/ route to show a form for a link edition
		$this->app->get('/links/:id/edit', function($id){
			$link = $this->getLink($id);
			$link_statuses = $this->getStatuses('link.status');
			$this->app->render('links.edit', ['link' => $link, 'link_statuses' => $link_statuses, 'app' => $this->app]);
		})
		->name('links.edit')
		->conditions(['id' => '[0-9]+']);

		# Defines /links/:id POST route that handles the received data from the edition form
		$this->app->post('/links/:id', function($id){
			$link = $this->getLink($id);
			$params = $this->app->request->post();
			unset($params['save']);
			if($this->storeLink($params, $link))
				$this->app->redirect('/links');
			else
				$this->app->redirect("/links/$link->id/edit");
		})
		->name('links.update')
		->conditions(['id' => '[0-9]+']);

		# Defines /links/:id/delete/ route that deletes an id specified link
		$this->app->get('/links/:id/delete', function($id){
			$link = $this->getLink($id);
			$link->delete();
			$this->app->redirect('/links');
		})
		->name('links.delete')
		->conditions(['id' => '[0-9]+']);

		# start Slim
		$this->app->run();
	}

	# Fetches typed statuses from the lookup table
	public function getStatuses($type = 'link.status'){
		$statuses = Lookup::where('lookup.type', $type)->get();
		return $statuses;
	}

	# Fetches links from the database starting from an offset and limited from 0 and 10 by default respectively
	public function getLinks($limit = 10, $offset = 0){
		$links = Link::skip($offset)->take($limit)->with('status')->get();
		if(!$links)
			$this->app->notFound();
		else
			return $links;
	}

	# Fetches 1 link by id
	public function getLink($id){
		$link = Link::find($id);
		if(!$link)
			$this->app->notFound();
		else
			return $link;
	}

	# Stores either a new link or updates an old link
	public function storeLink($params, $link = null){
		if(!$link)
			$link = $this->newLink();
		$link->fill($params);
		if($this->validateInput($params) && $link->save()){
			//dd($link->toArray());
		    return $link;
		}
	    return false;
	}

	# Instantiates a new Link object
	public function newLink(){
		return new Link;
	}

	# Validates the 
	public function validateInput($params){
		$linkValidator = Validator::
			key('name', Validator::string()->length(3,128)->notEmpty())
			->key('uri', Validator::url()->length(13,128)->notEmpty())
			->key('status_code', Validator::int()->between(1, 6, true)->notEmpty());
		//dd($params);
		try{
			$linkValidator->assert($params);
			return true;
		}
		catch(NestedValidationExceptionInterface $exception) {
			$messages = $exception->findMessages(['string', 'int', 'url', 'between', 'notEmpty', 'length']);
			//dd($messages);
			$this->app->flash('link.errors', $messages);
			return false;
		}
	}

}