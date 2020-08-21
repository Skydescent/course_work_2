<?php
namespace App;

class Route
{
    private $method;
    private $path;
    private $callback;

    public function __construct(
        string $method, 
        string $path, 
        $callback
    )
    {
        $this->method = $method;
        $this->path = $this->preparePath($path);
        $this->callback = $this->prepareCallback($callback);
    }

    private function prepareCallback($callback)
    {
        if (is_null($callback)) {
            return null;
        }
        if (is_callable($callback)) {
            return $callback;
        } else if (gettype($callback === 'string')) {
            list($class, $method) = explode('@', $callback);
            return [new $class, $method];
        }
    }

    private function preparePath($path)
    {
        return '/' . trim($path, '/');
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function match($method, $uri)
    {
        $matchUri = ($this ->getPath() === $uri || 
            preg_match($this->getPattern() , $uri));

        return ($method === $this->getMethod() && $matchUri);
    }

    protected function getPattern()
    {
        return '/^' . str_replace([ '*', '/' ], ['(\w+)' , '\/' ], $this ->getPath()) . '$/';
    }

    public function run($uri)
    {
        preg_match($this->getPattern(), $uri, $matches);
        array_shift($matches);

        if (count($matches) > 0) {
            if (is_null($this->getCallback())) {
                $class = 'App\Controller\\' . $this->upperCamelCase($matches[0]) . 'Controller';
                $method = $matches[1];
                if (!class_exists($class) || !method_exists(new $class, $method)) {
                    throw new Exception\NotFoundException();
                }
                $_SESSION['debug'] = array_values(array_slice($matches, 2));
                return call_user_func_array([new $class, $method], array_values(array_slice($matches, 2)));
            }
            return call_user_func_array($this->getCallback(), array_values($matches));
        } else {
            return ($this->getCallback())();
        }
    }

    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
}
