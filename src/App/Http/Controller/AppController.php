<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Silex\Application;

class AppController
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function home()
    {
        return 'home action';
    }

    public function demo()
    {
        return 'demo action';
    }

    public function json(Application $app)
    {
        return $app->json(['zz' => 'bar']);
    }

    public function exception()
    {
        throw new \LogicException('test exception');
    }
}
