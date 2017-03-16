<?php

declare(strict_types = 1);

use Silex\Provider\ServiceControllerServiceProvider;

$app = new Silex\Application();

require __DIR__."/../config/prod.php";

// PROVIDERS
// ...

if (getenv('APP_ENV') === "development") {
    require __DIR__."/../config/dev.php";
    require __DIR__."/dev.php";
} elseif (getenv('APP_ENV') === "testing") {
    require __DIR__."/../config/test.php";
}

// ROUTES

$app->register(new ServiceControllerServiceProvider());
$app->mount('/', new \App\Provider\Route\AppControllerProvider());

return $app;
