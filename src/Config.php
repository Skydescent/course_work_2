<?php

namespace App;

use App\Model\Setting;
use function helpers\createArrayTree;
use function helpers\arrayGet;

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
	    if (($config == 'file.maxSize.default' ||
            $config == 'pagination.selects.default') &&
            (isset($_SESSION['auth_subsystem']) && (
                $_SESSION['auth_subsystem']['role'] !== 'admin' &&
                $_SESSION['auth_subsystem']['role'] !== 'manager'
                )
            )
        ) {
            $settings = Setting::all();
            if (!is_null($settings)) {
                $settings = $settings->toArray();
                $settings = createArrayTree($settings);
                return arrayGet($settings, $config, $default);
            }
        }
		return arrayGet($this->configs, $config, $default);
	}

}
