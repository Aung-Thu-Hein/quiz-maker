<?php

use Core\App;
use Core\Container;
use Core\Router;
use Core\DB;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'core/Functions.php';

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$router = new Router($container);

$container->set(DB::class, function() {
    return new DB();
});

require BASE_PATH . 'routes/route.php';

$app = new App(['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']], $router);
$app->run();