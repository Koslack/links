<?php
	require('../vendor/autoload.php');

	ORM::configure('sqlite:../store/app.sqlite.db');
	ORM::configure('logging', true);

	$app = new \Slim\Slim([
		'view' => new \Slim\Views\Blade(),
		'templates.path' => '../templates'
	]);

	$views = $app->view();
	$views->parserOptions = [
		'debug' => true,
		'cache' => '../html_cache'
	];

	$app->get('/', function() use ($app){
		$app->redirect('/links', 301);
	});

	$app->get('/links', function() use ($app){
		$links = ORM::forTable('links')->findMany();
		$app->render('links.index', compact('links', 'app'));
	})->name('links.index');

	$app->get('/links/:id', function($id) use ($app){
		$link = ORM::forTable('links')->findOne($id);
		if(!$link)
			$app->response($app->render('errors.404'), '404');
		else
			$app->render('links.show', compact('link', 'app'));
	})->name('link.show');

	$app->get('/links/create/', function() use ($app){
		$app->render('links.create', compact('app'));
	})->name('link.create');

	$app->post('/links', function() use ($app){
		$link = ORM::forTable('links')->create();
		$link->set('name', $_POST['name']);
		$link->set('url', $_POST['url']);
		$link->set('status', $_POST['status']);
		$link->save();
		$app->redirect('/links/'.$link->id);
	})->name('link.store');

	$app->get('/links/:id/edit/', function($id) use ($app){
		$link = ORM::forTable('links')->findOne($id);
		$app->render('links.edit', compact('link', 'app'));
	})->name('link.edit');

	$app->post('/links/:id', function($id) use ($app){
		$link = ORM::forTable('links')->findOne($id);
		$link->set('name', $_POST['name']);
		$link->set('url', $_POST['url']);
		$link->set('status', $_POST['status']);
		$link->save();
		$app->redirect('/links/'.$link->id);
	})->name('link.update');

	$app->get('/links/:id/delete/', function($id) use ($app){
		$link = ORM::forTable('links')->findOne($id);
		$link->delete();
		$app->redirect('/links');
	})->name('link.delete');

	$app->run();