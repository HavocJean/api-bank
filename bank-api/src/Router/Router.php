<?php

namespace App\Router;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, $action) :void {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {

            if ($route['method'] === $method && $route['uri'] === $uri) {
                $action = $route['action'];

                call_user_func($action);

                return;
            }
        }

        http_response_code(404);

        echo json_encode([
            'error' => 'Route not found'
        ]);
    }
}