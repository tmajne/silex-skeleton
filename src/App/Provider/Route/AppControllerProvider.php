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

        $app = $app['controllers_factory'];

        $app->get('/', function () {
            return 'Test Service Controller home page';
        })->bind('home');

        $app->get('/demo', 'app.controller:demo')
            ->bind('demo');

        $app->get('/json', 'app.controller:json')
            ->bind('json');

        $app->get('/exception', 'app.controller:exception')
            ->bind('exception');

        // EXAMPLES
        
        /*$app->get('/exception', 'App\\Http\\Controller\\AppController::json')
            ->bind('exception');*/

        /*$app->get('/hello/{name}', function ($name) use ($app) {
                return 'Hello '.$app->escape($name);
            });*/

        return $app;
    }
}
