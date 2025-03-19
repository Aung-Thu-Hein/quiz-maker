<?php

namespace Core;

use App\Questions\Contracts\QuestionDaoInterface;
use App\Questions\Contracts\QuestionServiceInterface;
use App\Questions\DAOs\QuestionDao;
use App\Questions\Services\QuestionService;
use Core\Exceptions\RouteNotFoundException;

use App\Quizzes\Contracts\QuizDaoInterface;
use App\Quizzes\Contracts\QuizServiceInterface;
use App\Quizzes\DAOs\QuizDao;
use App\Quizzes\Services\QuizService;

class App
{
    public function __construct(
        protected Container $container,
        protected Router $router
    ){
        $container->set(QuizServiceInterface::class, QuizService::class);
        $container->set(QuizDaoInterface::class, QuizDao::class);
        $container->set(QuestionServiceInterface::class, QuestionService::class);
        $container->set(QuestionDaoInterface::class, QuestionDao::class);
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch(RouteNotFoundException) {
            http_response_code(404);

            echo "Route Not Found....";
        }
    }
}
