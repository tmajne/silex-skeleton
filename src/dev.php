<?php

declare(strict_types=1);

use App\Provider\WhoopsServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

$app['debug'] = true;

// Providers for Silex Web Profiler
$app->register(new HttpFragmentServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());

//If you are using MonologServiceProvider for logs, you must also add
// symfony/monolog-bridge as a Composer dependency to get the logs in the profiler.
//If you are using VarDumperServiceProvider, add symfony/debug-bundle as a Composer dependency
// to display VarDumper dumps in the toolbar and the profiler.

// Silex Web Profiler
$app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    'profiler.mount_prefix' => '/_profiler', // this is the default
));


// Whoops
$app->register(new WhoopsServiceProvider());


// if you wand define your error handler per exception type
/*$app->error(function (\LogicException $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    return new Response('We are sorry, but something went terribly wrong. - LogicException');
});
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    return new Response('We are sorry, but something went terribly wrong. - Exception');
});*/
