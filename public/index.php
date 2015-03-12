<?php
	require('../vendor/autoload.php');

	$app = new \Slim\Slim([
		'view' => new \Slim\Views\Blade(),
		'templates.path' => '../templates'
	]);

	$views = $app->view();
	$views->parserOptions = [
		'debug' => true,
		'cache' => '../html_cache'
	];

	$app->get('/hey', function() use ($app){
		$app->render('index');
	});

	$app->run();