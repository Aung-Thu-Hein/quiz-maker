<?php

namespace Core;

use Core\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
        //    
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $pattern = preg_replace('/\{\w+\}/', '([^/]+)', $route);
        $this->routes[$requestMethod][$pattern] = [
            'action' => $action,
            'params' => $this->getRouteParams($route)
        ];
        
        return $this;
    }

    public function getRouteParams(string $route): array
    {
        preg_match_all('/\{(\w+)\}/', $route, $matches);
        return $matches[1];
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
        return $this->register('put', $route, $action);
    }

    public function patch(string $route, callable|array $action): self
    {
        return $this->register('patch', $route, $action);
    }

    public function delete(string $route, callable|array $action): self
    {
        return $this->register('delete', $route, $action);
    }

    public function resolve(string $requestMethod)
    {
        $route = parse_url($_SERVER['REQUEST_URI'])['path'];

        foreach ($this->routes[$requestMethod] as $pattern => $routeData) {
            if (preg_match("#^$pattern$#", $route, $matches)) {
                
                array_shift($matches);
                
                $params = array_combine($routeData['params'], $matches);

                $action = $routeData['action'];

                if (is_callable($action)) {
                    return call_user_func_array($action, $params);
                }

                [$class, $method] = $action;

                if (class_exists($class)) {
                    $class = $this->container->get($class);

                    if (method_exists($class, $method)) {
                        return call_user_func_array([$class, $method], $params);
                    }
                }
                throw new RouteNotFoundException();
            }
        }
        throw new RouteNotFoundException();
    }
}
