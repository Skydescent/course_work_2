<?php

namespace App;

class Router
{
    /**
     * Метод маршрута GET
     */
    const GET = 'GET';

    /**
     * Метод маршрута POST
     */
    const POST = 'POST';

    /**
     * Массив с маршрутами, поделёнными на две группы
     *
     * @var array[]
     */
    private $routes = [
        self::GET => [],
        self::POST => []
    ];

    /**
     * Добавляет маршурт в массив экземпляра класса GET
     *
     * @param string $path
     * @param null $callback
     */
    public function get(string $path, $callback = null)
    {
        $this->routes[self::GET][] = new Route(self::GET, $path, $callback);
    }

    /**
     * Добавляет маршурт в массив экземпляра класса POST
     *
     * @param string $path
     * @param $callback
     */
    public function post(string $path, $callback)
    {
        $this->routes[self::POST][] = new Route(self::POST, $path, $callback);
    }

    /**
     * Добавляет маршурт в массив экземпляра класса POST и GET
     *
     * @param string $path
     * @param null $callback
     */
    public function request(string $path, $callback = null)
    {
        $this->get($path, $callback);
        $this->post($path, $callback);
    }

    /**
     * Сравнивает текущий маршрут с маршрутами объекта, в случае успеха запускает маршрут
     * в случае неудачи выбрасывает исключение NotFound
     *
     * @return mixed
     * @throws Exception\NotFoundException
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->removeQueryString($_SERVER['REQUEST_URI']);

        foreach ($this->routes[$method] as $route) {
            if ($route->match($method, $uri)) {
                return $route->run($uri);
            }
        }
        throw new Exception\NotFoundException();
    }

    /**
     * Удаляет GET параметры из URL
     *
     * @param $url
     * @return mixed|string
     */
    protected function removeQueryString($url)
    {
        if ($url) {
            if (strpos($url, '?') !== false) {
                return explode('?', $url)[0];
            } else {
                return $url;
            }
        }
    }
}
