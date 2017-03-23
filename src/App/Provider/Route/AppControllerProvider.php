<?php

declare(strict_types=1);

namespace App\Provider\Route;

use App\Http\Controller\AppController;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class AppControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['app.controller'] = function ($app) {
            return new AppController($app);
        };

        $controller = $app['controllers_factory'];

        $controller->get('/', function () {
            return 'Test Service Controller home page';
        })->bind('home');

        $controller->get('/demo', 'app.controller:demo')
            ->bind('demo');

        $controller->get('/json', 'app.controller:json')
            ->bind('json');

        $controller->get('/exception', 'app.controller:exception')
            ->bind('exception');

        // EXAMPLES
        $controller->get('/example/class/namespace', 'App\\Http\\Controller\\AppController::json')
            ->bind('example.exception');

        $controller->get('/example/callback/hello/{name}', function ($name) use ($app) {
                return 'Hello '.$app->escape($name);
            });

        return $controller;
    }
}
