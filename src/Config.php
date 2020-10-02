<?php

namespace App;

use function helpers\array_get;

final class Config
{
    /**
     * Единственный кземпляр класса
     *
     * @var
     */
    private static $instance;

    /**
     * Массив с настройками, подгружаемыми из файлов
     *
     * @var array
     */
    private $configs = [];

    /**
     * Config constructor.
     */
    private function __construct() {
            $this->initialize();
	}

    /**
     * Добавляет настройки в массив configs экземпляра класса
     * из директории configs по именам файлов со значением подключённых файлов
     */
	private function initialize()
    {
        if ($handle = opendir(ROOT . DIRECTORY_SEPARATOR . CONFIGS_DIR)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry !== '.' && $entry !== '..') {
                    $name = rtrim ($entry, '.php');
                    $this->configs[$name] = require CONFIGS_DIR . DIRECTORY_SEPARATOR . $entry;
                }
            }

            closedir($handle);
        }
    }

    /**
     * Возвращает единственный экземпляр класса
     *
     * @return Config
     */
    public static function getInstance() : Config
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

    /**
     * Возвращает значение настройки из массива configs
     *
     * @param $config
     * @param null $default
     * @return string|array|null
     */
    public function get($config, $default = null)
	{
		return array_get($this->configs, $config, $default);
	}

}
