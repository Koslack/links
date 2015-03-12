<?php
	require('../vendor/autoload.php');

	$app = new \Slim\Slim();

	$app->get('/hey', function(){
		echo "hi there!!";
	});

	$app->run();