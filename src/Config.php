<?php
namespace App;

final class Config
{
	private static $instance; 
	private $configs = [];

	private function __construct() {
		$this->configs['db'] = require 'configs/db.php';
		$this->configs['valid_err_msgs'] = require 'configs/valid_err_msgs.php';
		$this->configs['file'] = require 'configs/file.php';
        $this->configs['pagination'] = require 'configs/pagination.php';
	}

	public static function getInstance() : Config
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function get($config, $default = null)
	{
		return \helpers\array_get($this->configs, $config, $default);
	}

}
