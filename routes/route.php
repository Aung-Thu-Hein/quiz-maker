<?php

use App\Quizzes\Controllers\QuizController;
use Core\Container;
use Core\DB;

$router->get('/', function() {
    $db = (new Container)->get(DB::class);

    $query = 'SELECT * FROM products';
    foreach($db->query($query) as $product) {
        echo '<pre>';
        var_dump($product);
        echo '</pre>';
    }
});

$router->post('/quiz', [QuizController::class, 'store']);
