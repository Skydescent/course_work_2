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
     * @param $alias
     * @return View
     * @throws NotFoundException
     */
    public function page(string $alias)
    {
        $page = Model\StaticPages::query()
            ->where('is_active', '=', '1')
            ->where('alias', '=', $alias)
            ->first();
        if (!is_null($page)) {
            return $this->getView(__METHOD__, ['page' => $page]);
        }
        throw new NotFoundException();
    }
}