<?php
namespace AlphaPit;

use AlphaPit\Attributes\Route;
use AlphaPit\DI\ServiceContainer;
use AlphaPit\Module;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, callable $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function registerController(string $controller, ServiceContainer $container): void
    {
        $reflection = new \ReflectionClass($controller);
        $instance = $container->get($controller);

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            foreach ($method->getAttributes(Route::class) as $attribute) {
                /** @var Route $route */
                $route = $attribute->newInstance();
                $this->routes[$route->method][$route->path] = [$instance, $method->getName()];
            }
        }
    }

    public function registerModule(Module $module, ServiceContainer $container): void
    {
        $module->register($this, $container);
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo 'Not Found';
            return;
        }

        echo call_user_func($action);
    }
}
