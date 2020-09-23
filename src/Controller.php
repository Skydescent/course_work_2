<?php
namespace App;

use App\Helpers\Pagination;
use App\View;
use App\Model;
use function helpers\h;
use function helpers\redirect;

abstract class Controller
{
    protected function getLayoutName($method)
    {
        return explode('::', $method)[1];
    }

    protected function getView($method =  NULL, $options = NULL)
    {
        $layout = is_null($method) ? DEFAULT_LAYOUT : $this->getLayoutName($method);
        $path = str_replace(['App\Controller\\', 'Controller'], ['',''], get_class($this));
        $layout = $layout ?? DEFAULT_LAYOUT;
        $layout = $path . '.' . $layout;
        return new View\View($layout, $options);
    }
    
    protected function getCurrentPage()
    {
        if (isset($_GET['page'])) {
            return  (int) h($_GET['page']);
        } else {
            return 1;
        }
    }

    protected function paginate($model, $uri, bool $isSelect = false)
    {
        $currentPage = $this->getCurrentPage();
        if (is_int($model)) {
            $total = $model;
        } else {
            $method = $model . '::query';
            $total = $method()->count();
        }

        $pagination = new Pagination($currentPage, $total, $uri, $isSelect);
        return $pagination;
    }

    protected function update($name, $model, $field)
    {
        [$id, $newVal] = explode('_', h($_POST[$name]));
        $method = $model . '::find';
        $user = $method($id);
        $user[$field] = $newVal;
        $user->save();
        redirect();
    }
}
