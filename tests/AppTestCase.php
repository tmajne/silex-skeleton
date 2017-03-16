<?php

declare(strict_types=1);

namespace App\Test;

use Silex\Application;
use Silex\WebTestCase;

class AppTestCase extends WebTestCase
{
    public function createApplication() : Application
    {
        $app = require __DIR__."/../src/bootstrap.php";

        // configuration app for test
        // ..

        return $app;
    }
}
