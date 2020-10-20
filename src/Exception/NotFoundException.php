<?php

namespace App\Exception;

use App\View;
use Throwable;

class NotFoundException extends HttpException implements View\Renderable
{
    /**
     * Передаёт данные для объекта класса View для отображения данного вида ошибок.
     *
     * @throws NotFoundException
     */
    public function render()
    {
        $msg = 'Страница с данным адресом ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . ' не найдена!' . PHP_EOL .
            $this->message . " " . $this->getFile() . " " . $this->getLine();
        (new View\View('exception', ['title' => 'Ошибка404!', 'text' => $msg]))->render();
    }
}
