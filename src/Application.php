<?php
namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    private function initialize()
    {
        session_start();
        $capsule = new Capsule;
        $configs = Config::getInstance();
        $capsule->addConnection([
            'driver'    => $configs->get('db.driver'),
            'host'      => $configs->get('db.host'),
            'database'  => $configs->get('db.database'),
            'username'  => $configs->get('db.username'),
            'password'  => $configs->get('db.password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function run()
    {
        try {
            $result = $this->router->dispatch();
            if ($result instanceof View\Renderable) {
                $result->render();
            } else {
                echo $result;
            }
        } catch (\Exception $e) {
            $this->renderException($e);
        }


    }

    public function renderException($e)
    {
        if ($e instanceof View\Renderable) {
            $e->render();
        } else {
            $errCode = $e->getCode() === 0 ? 500 : $e->getCode();
            echo 'Ошибка: ' . $errCode . ' ' . $e->getMessage();
            echo ' В файле: ' . $e->getFile() . ' в строке ' . $e->getLine();
        }
    }
}
