<?php

namespace Core;

use Core\Exceptions\ContainerException;
use Core\Exceptions\RouteNotFoundException;
use Core\Http\Request;

class Router
{
    const PREFIX_ROUTE = "api/v1";

    private array $routes = [];
    public Request $request;

    public function __construct(private Container $container)
    {
        $this->request = $this->container->get(Request::class);
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $route = $this->format(self::PREFIX_ROUTE) . $this->format($route);

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

    public function resolve()
    {
        $path = $this->request->getPath();
        $route = $this->format($path);

        $requestMethod = $this->request->getMethod();

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
                        $resolvedParams = $this->resolveParameter($class, $method, $params);
                        return call_user_func_array([$class, $method], $resolvedParams);
                    }
                }
                throw new RouteNotFoundException();
            }
        }
        throw new RouteNotFoundException();
    }

    public function resolveParameter(object|string $class, string $method, array $params): array
    {
        $reflection = new \ReflectionMethod($class, $method);
        $parameters = $reflection->getParameters();

        $resolvedParams = [...$params];
        
        foreach($parameters as $param){
            $type = $param->getType();
            $name = $param->getName();

            if(!$type) {
                throw new ContainerException(
                    "Failed to resolve class $param, because param $name is missing type hint"
                );
            }

            if($type instanceof \ReflectionUnionType) {
                throw new ContainerException(
                    "Failed to resolve class $param, because of the union type param $name"
                );
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin() && $type->getName() === Request::class) {
                $resolvedParams[$name] = $this->request;
            }

            if($type instanceof \ReflectionNamedType && !$type->isBuiltin() && $type->getName() !== Request::class) {
                $resolvedParams[$name] = $this->container->get($type->getName());
            }
        }
        return $resolvedParams;
    }

    public function format(string $route): string
    {
        if(substr($route, 0, 1) != '/') {
            $route = '/' . $route;
        }
        
        if(substr($route, -1) == '/') {
            $route = substr($route, 0, -1);
        }

        return $route;
    }
}
