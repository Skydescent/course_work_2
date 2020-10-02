<?php

namespace App;

use App\Exception\NoRightsException;

class Route
{
    /**
     * Метод GET или POST
     *
     * @var string
     */
    private $method;

    /**
     * Путь маршрута
     *
     * @var string
     */
    private $path;

    /**
     * Функция, вызываемый метод класса при совпадении маршрута
     *
     * @var array|callable|null
     */
    private $callback;

    /**
     * Массив с ключами в виде ролей и доступом в виде строк и массивов с маршрутами
     *
     * @var
     */
    private $rolesAccess;

    /**
     * Route constructor.
     *
     * @param string $method
     * @param string $path
     * @param $callback
     */
    public function __construct(
        string $method, 
        string $path, 
        $callback
    )
    {
        $this->initialize();
        $this->method = $method;
        $this->path = $this->preparePath($path);
        $this->callback = $this->prepareCallback($callback);
    }

    /**
     * Загрузка массива с доступами к маршрутам из Config
     *
     */
    protected function initialize()
    {
        $configs = Config::getInstance();
        $this->rolesAccess = $configs->get('rolesAccess');
    }

    /**
     * Подготовка функции/метода класса для записи в свойство объекта класса
     *
     * @param $callback
     * @return array|callable|null
     */
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

    /**
     * Подготовка строки с путём маршрута для записи в свойство объекта класса
     *
     * @param $path
     * @return string
     */
    private function preparePath($path)
    {
        return '/' . trim($path, '/');
    }

    /**
     * Возвращает путь маршрута
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Возвращает метод get или post маршрута
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Возращает коллбэк маршрута
     *
     * @return array|callable|null
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Сравнивает текущий uri с путём(шаблоном) маршрута
     *
     * @param $method
     * @param $uri
     * @return bool
     */
    public function match($method, $uri)
    {
        $matchUri = ($this ->getPath() === $uri || 
            preg_match($this->getPattern() , $uri));

        return ($method === $this->getMethod() && $matchUri);
    }

    /**
     * Из пути(шаблона) маршрута получает RegExp
     *
     * @return string
     */
    protected function getPattern()
    {
        return '/^' . str_replace([ '*', '/' ], ['(\w+)' , '\/' ], $this ->getPath()) . '$/';
    }

    /**
     * Запускает коллбэк маршрута
     * В случае если метод класса (класс) не сущетсвует - выбрасывает исключение NotFound
     * В случае если роль запрашивающего маршрут пользователя не соответсвует правам доступа - выбрасывается NoRights
     *
     * @param $uri
     * @return mixed
     * @throws Exception\NotFoundException
     * @throws NoRightsException
     */
    public function run($uri)
    {
        preg_match($this->getPattern(), $uri, $matches);
        array_shift($matches);

        if (count($matches) > 0) {
            if (is_null($this->getCallback())) {
                $class = 'App\Controller\\' . $this->upperCamelCase($matches[0]) . 'Controller';
                $method = $matches[1];
                $_SESSION['debug'] = $this->checkRoleAccess($uri);
                if (!class_exists($class) ||
                    (!method_exists(new $class, $method) && !method_exists(new $class, '__call'))
                ) {
                    throw new Exception\NotFoundException();
                }
                if ($this->checkRoleAccess($uri) === false) {
                    throw new Exception\NoRightsException();
                }
                return call_user_func_array([new $class, $method], array_values(array_slice($matches, 2)));
            }
            return call_user_func_array($this->getCallback(), array_values($matches));
        } else {
            return ($this->getCallback())();
        }
    }

    /**
     * Привдит передаваемую строку в стиль upperCamelCase
     *
     * @param $name
     * @return string|string[]
     */
    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * Проверяет доступ пользователя к маршруту по роли, заданной в сессии
     * и зданному через Config массиву с именами ролей и доступами
     *
     * @param $uri
     * @return bool
     */
    private function checkRoleAccess($uri)
    {
        if (!isset($_SESSION['auth_subsystem']['role'])) {
            $role = 'unregistered';
        } else {
            $role = $_SESSION['auth_subsystem']['role'];
        }

        $access = $this->rolesAccess[$role];

        if ($access === 'all') return true;

        if (array_key_exists('no_access',$access)) {
            foreach ($access['no_access'] as $value) {
                if (stripos($uri, $value) !== false) {
                    return false;
                }
            }
        }
        return true;
    }
}
