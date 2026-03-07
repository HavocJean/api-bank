<?php

namespace App\Router;

use App\Helpers\Response;

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

        Response::error("Route not found", 404);
    }
}