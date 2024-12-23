<?php

namespace Core;

use Core\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        
        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function put(string $route, callable|array $action): self
    {
        return $this->put('put', $route, $action);
    }

    public function patch(string $route, callable|array $action): self
    {
        return $this->patch('patch', $route, $action);
    }

    public function delete(string $route, callable|array $action): self
    {
        return $this->delete('delete', $route, $action);
    }

    public function resolve(string $requestMethod)
    {
        $route = parse_url($_SERVER['REQUEST_URI'])['path'];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if(!$action) {
            throw new RouteNotFoundException();
        }

        if(is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if(class_exists($class)) {
            $class = new $class;

            if(method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }
}
