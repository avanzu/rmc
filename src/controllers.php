<?php
/** @var $app \Silex\Application */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    /** @var \Repository\StatsRepository $repo */
    $repo = $app['repository.stats'];
    return $app['twig']->render('index.html.twig', array(
        'columns' => $repo->getColumns()
    ));
})
->bind('homepage')
;

$app->get('/records', function() use ($app){

    /** @var \Repository\StatsRepository $repo */
    $repo = $app['repository.stats'];
    return new JsonResponse([ 'data' => $repo->loadRecords() ]);

})->bind('records');



$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
