<?php

namespace App;

use App\Helpers\Pagination;
use App\View;

use function helpers\htmlSecure;
use function helpers\redirect;

abstract class Controller
{
    /**
     * Возвращает имя шаблона для подключения
     *
     * @param $method
     * @return mixed|string
     */
    protected function getLayoutName($method)
    {
        return explode('::', $method)[1];
    }

    /**
     * Возвращает объект вида с переданными именем шаблона и данными для отображения
     *
     * @param null|string $method
     * @param null|array $options
     * @return View\View
     */
    protected function getView($method =  NULL, $options = NULL)
    {
        $layout = is_null($method) ? DEFAULT_LAYOUT : $this->getLayoutName($method);
        $path = str_replace(['App\Controller\\', 'Controller'], ['',''], get_class($this));
        $layout = $layout ?? DEFAULT_LAYOUT;
        $layout = $path . '.' . $layout;
        return new View\View($layout, $options);
    }

    /**
     * Возвращает значение текущей страницы пагинации из GET параметров
     *
     * @return int
     */
    protected function getCurrentPage()
    {
        if (isset($_GET['page'])) {
            return  (int)htmlSecure($_GET['page']);
        } else {
            return 1;
        }
    }

    /**
     * Возвращает объект пагинации
     *
     * @param $model
     * @param $uri
     * @param bool $isSelect
     * @return Pagination
     */
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

    /**
     * Обновляет запись в БД
     *
     * @param $name
     * @param $modelClass
     * @param $field
     */
    protected function update($name, $modelClass, $field)
    {
        [$id, $newVal] = explode('_',htmlSecure($_POST[$name]));
        $method = $modelClass . '::find';
        $user = $method($id);
        $user[$field] = $newVal;
        $user->save();
        redirect();
    }

    protected function getFile($model)
    {
        return $_FILES['img']['size'] !== 0 ? $model->uploadFile($_FILES['img'], 'img', 'img', 'post'.date('h_i_s')) : null;
    }
}
