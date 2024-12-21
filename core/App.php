<?php

namespace Core;

use App\Exceptions\RouteNotFoundException;

class App
{
    public function __construct(
        protected array $request, 
        protected Router $router
    ){}

    public function run(): void
    {
        try {
            echo $this->router->resolve(strtolower($this->request['method']));
        } catch(RouteNotFoundException) {
            http_response_code(404);

            echo "Route Not Found!......";
        }
    }
}
