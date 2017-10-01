<?php

// configure your app for the production environment
$params = require __DIR__. '/params.php';

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');


