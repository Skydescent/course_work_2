<?php


namespace App\Exception;

use App\View;

class NoRightsException extends HttpException implements View\Renderable
{
    public function render()
    {
        (new View\View('noRights'))->render();
    }
}