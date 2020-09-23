<?php


namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model;

class StaticController extends \App\Controller
{
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