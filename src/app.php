<?php

use Repository\StatsRepository;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Translation\Translator;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;

$app = new Application(require __DIR__.'/../config/params.php');

$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider(), ['db.options' => $app['db.options']]);
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array( 'locale' => $app['default_locale'], 'locale_fallbacks' => $app['fallback_locales']));

$app->extend('translator', function (Translator $translator, $app) {
        $translator->addResource('xliff', __DIR__.'/../locales/en.xlf', 'en');
        $translator->addResource('xliff', __DIR__.'/../locales/de.xlf', 'de');
        return $translator;
    });

$app->extend('twig',function (Twig_Environment $twig, $app) {
        $twig->addGlobal('default_locale', $app['default_locale']);
        $twig->addFunction(New Twig_SimpleFunction('datatables_i18n', function($locale = null) use ($app){
            $locale = $locale?: $app['request_stack']->getCurrentRequest()->getLocale();
            return file_get_contents(sprintf(__DIR__.'/../locales/datatables/%s.json', $locale));

        }));
        return $twig;
});


$app['repository.stats'] = function ($app) {
    return new StatsRepository($app['db']);
};

return $app;
