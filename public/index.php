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

	$app->get('/links', function() use ($app){
		$links = ORM::forTable('links')->findMany();
		$app->render('links.index', compact('links'));
	});

	$app->get('/links/:id', function($id) use ($app){
		$link = ORM::forTable('links')->findOne($id);
		if(!$link)
			$app->response($app->render('errors.404'), '404');
		else
			$app->render('links.show', compact('link'));
	});


	$app->run();