<?php

namespace App\Controller;

use App\Controller;
use App\Exception\NotFoundException;
use App\Model;
use App\View\View;

class StaticController extends Controller
{
    /**
     * Получает данные из БД и отображет их в случае нахождения запрашиваемого URL.
     *
     * @param $name
     * @param $arguments
     * @return View
     * @throws NotFoundException
     */
    public function __call($name, $arguments) {
        $pages = Model\StaticPages::query()
            ->select('*')
            ->where('is_active', '=', '1')
            ->get();
        foreach ($pages as $page) {
            if ($page->alias == $name) {
                return $this->getView('App\Controller\StaticController::static', ['page' => $page]);
            }
        }
        throw new NotFoundException();
    }
}