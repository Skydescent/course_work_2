<?php

namespace App\Exception;

use App\View;

class NoRightsException extends HttpException implements View\Renderable
{
    /**
     * Передаёт данные для объекта класса View для отображения данного вида ошибок.
     *
     * @throws NotFoundException
     */
    public function render()
    {
        $msg = 'У вас нет доступа к данной странице!';
        (new View\View('exception', ['title' => 'Ошибка прав доступа!', 'text' => $msg]))->render();
    }
}