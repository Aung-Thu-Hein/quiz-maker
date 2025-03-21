<?php

use Core\App;
use Core\Container;
use Core\Router;
use Core\DB;
use Core\Http\Request;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'core/functions.php';

require_once __DIR__ . '/../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(BASE_PATH);
$dotEnv->load();

$container = new Container();
$router = new Router($container);

$container->set(DB::class, function() {
    return new DB();
});

$container->set(Request::class, function() {
    return new Request();
});

require BASE_PATH . 'routes/route.php';

$app = new App($container, $router);
$app->run();
