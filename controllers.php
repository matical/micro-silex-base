<?php

use Silex\Application as App;
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function (App $app, Request $request) {
    return $app['twig']->render('index.twig', ['routes' => $app['routes']]);
});
