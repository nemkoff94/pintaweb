<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function __construct(private readonly array $config)
    {
    }

    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function dispatch(Request $request): void
    {
        $route = $this->routes[$request->method()][$request->path()] ?? null;

        if ($route === null) {
            http_response_code(404);
            View::render('errors.404', [
                'config' => $this->config,
                'title' => 'Страница не найдена',
            ]);

            return;
        }

        foreach ($route['middleware'] as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->handle($request);
        }

        [$controllerClass, $method] = $route['handler'];
        $controller = new $controllerClass($this->config);
        $controller->{$method}($request);
    }

    private function addRoute(string $method, string $path, array $handler, array $middleware): void
    {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }
}
