<?php
namespace App;

use \Slim\Slim as Slim;
use \Slim\Middleware\SessionCookie as SessionCookie;
use \Slim\Views\Blade as Blade;
use \Respect\Validation\Exceptions\NestedValidationExceptionInterface as NestedValidationExceptionInterface;
use \Respect\Validation\Validator as Validator;

class LinkManager{

	protected $app;

	public function __construct(){
		$this->app = new Slim([
			# Adds application settings
			'view' => new Blade(),
			'templates.path' => 'views'
		]);
		$this->app->add(new SessionCookie());

		$views = $this->app->view();
		$views->parserOptions = [
			'debug' => true,
			'cache' => '../html_cache'
		];

		\ORM::configure('sqlite:../store/app.sqlite.db');
		\ORM::configure('logging', true);

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
		})->name('links.index');

		# Defines /links/create/ route to show a form for link creation
		$this->app->get('/links/create/', function(){
			$this->app->render('links.create', ['app' => $this->app]);
		})->name('links.create');

		# Defines /links POST route that handles the received data from the creation form and stores it
		$this->app->post('/links', function(){
			$params = $this->app->request->post();
			unset($params['save']);
			$link = $this->storeLink($params);
			//var_dump($link); die();
			if($link)
				$this->app->redirect('/links/' . $link->id);
			else
				$this->app->redirect('/links/create/');
		})->name('links.store');

		# Defines /links/:id for showing a single link
		$this->app->get('/links/:id', function($id){
			$link = $this->getLink($id);
			$this->app->render('links.show', ['link' => $link, 'app' => $this->app]);
		})->name('links.show');

		# Defines /links/:id/edit/ route to show a form for a link edition
		$this->app->get('/links/:id/edit/', function($id){
			$link = $this->getLink($id);
			$this->app->render('links.edit', ['link' => $link, 'app' => $this->app]);
		})->name('links.edit');

		# Defines /links/:id POST route that handles the received data from the edition form
		$this->app->post('/links/:id', function($id){
			$link = $this->getLink($id);
			$params = $this->app->request->post();
			unset($params['save']);
			if($this->storeLink($params, $link))
				$this->app->redirect('/links');
			else
				$this->app->redirect("/links/$link->id/edit");
		})->name('links.update');

		# Defines /links/:id/delete/ route that deletes an id specified link
		$this->app->get('/links/:id/delete/', function($id){
			$link = $this->getLink($id);
			$link->delete();
			$this->app->redirect('/links');
		})->name('links.delete');

		# start Slim
		$this->app->run();
	}

	# Fetches links from the database starting from an offset and limited from 0 and 10 by default respectively
	public function getLinks($limit = 10, $offset = 0){
		$links = \ORM::forTable('links')
			->limit($limit)
			->offset($offset)
			->findMany();
		if(!$links)
			$this->app->notFound();
		else
			return $links;
	}

	# Fetches 1 link by id
	public function getLink($id){
		$link = \ORM::forTable('links')->findOne($id);
		if(!$link)
			$this->app->notFound();
		else
			return $link;
	}

	public function storeLink($params, $link = null){
		if(!$link)
			$link = $this->newLink();
		$link->set($params);
		//var_dump($link); die();
		if($this->validateInput($params) && $link->save())
		    return $link;
	    return false;
	}

	public function newLink(){
		$link = \ORM::forTable('links')->create();
		return $link;
	}

	public function validateInput($params){
		$linkValidator = Validator::
			key('name', Validator::string()->notEmpty()->length(3,128))
			->key('uri', Validator::url()->length(3,128))
			->key('status', Validator::string()->in(['favorite', 'important'], true)->notEmpty());
		//var_dump($params);
		try{
			$linkValidator->assert($params);
			return true;
		}
		catch(NestedValidationExceptionInterface $exception) {
			$messages = $exception->findMessages(['string', 'url' => 'Link Uri({{input}}) must be an URL', 'in', 'notEmpty', 'length']);
			$this->app->flash('link.errors', $messages);
			return false;
		}
	}

}