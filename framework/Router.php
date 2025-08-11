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
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, callable $action): void
    {
        $pattern = preg_replace('#\{([^}]+)\}#', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[$method][] = ['pattern' => $pattern, 'action' => $action];
    }

    public function registerController(string $controller, ServiceContainer $container): void
    {
        $reflection = new \ReflectionClass($controller);
        $instance = $container->get($controller);

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            foreach ($method->getAttributes(Route::class) as $attribute) {
                /** @var Route $route */
                $route = $attribute->newInstance();
                $this->addRoute($route->method, $route->path, [$instance, $method->getName()]);
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
        $routes = $this->routes[$method] ?? [];
        foreach ($routes as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                try {
                    echo call_user_func_array($route['action'], $params);
                } catch (\Throwable $e) {
                    error_log($e->getMessage());
                    http_response_code(500);
                    echo 'Internal Server Error';
                }
                return;
            }
        }

        http_response_code(404);
        echo 'Not Found';
    }
}
