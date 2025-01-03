<?php

namespace Core;

use Core\Exceptions\RouteNotFoundException;

use App\Quizzes\Contracts\QuizDaoInterface;
use App\Quizzes\Contracts\QuizServiceInterface;
use App\Quizzes\DAOs\QuizDao;
use App\Quizzes\Services\QuizService;

class App
{
    public function __construct(
        protected Container $container,
        protected array $request, 
        protected Router $router
    ){
        $container->set(QuizServiceInterface::class, QuizService::class);
        $container->set(QuizDaoInterface::class, QuizDao::class);
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve(strtolower($this->request['method']));
        } catch(RouteNotFoundException) {
            http_response_code(404);

            echo "404 Not Found....";
        }
    }
}
