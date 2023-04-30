<?php

//  Load the application code.
/** @var Slim\App $app */
$app = require __DIR__ . '/blog-home.php';

// Bootstrap the slim framework to handle the request.
$app->run();
