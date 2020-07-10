<?php
namespace App;

class Router
{
    const GET = 'GET';
    const POST = 'POST';

    private $routes = [
        self::GET => [],
        self::POST => []
    ];

    public function get(string $path, $callback = null)
    {
        $this->routes[self::GET][] = new Route(self::GET, $path, $callback);
    }

    public function post(string $path, $callback)
    {
        $this->routes[self::POST][] = new Route(self::POST, $path, $callback);
    }

    public function request(string $path, $callback = null)
    {
        $this->get($path, $callback);
        $this->post($path, $callback);
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes[$method] as $route) {
            if ($route->match($method, $uri)) {
                return $route->run($uri);
            }
        }

        throw new Exception\NotFoundException();
    }
}
