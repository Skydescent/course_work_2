<?php


namespace App\Helpers;


class Pagination
{
    public $currentPage;
    public $perpage;
    public $total;
    public $countPages;
    public $uri;

    /**
     * Pagination constructor.
     * @param $page текущая
     * @param $perpage количество страниц из настроек
     * @param $currentPage текущая страница
     * @param $total общее количество записей
     */
    public function __construct($currentPage, $perpage, $total, $uri)
    {
        $this->currentPage = $currentPage;
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->uri = $uri;
    }


    /**
     * Метод при попытке вывода объекта выводит
     * HTML объекта
     * @return mixed
     */
    public function __toString()
    {
        return $this->getHtml();
    }

    public function getHtml()
    {
        $back = null;
        $forward = null;
        $startpage = null;
        $endpage = null;
        $page2left = null;
        $page1left = null;
        $page2right = null;
        $page1right = null;


        //формируем ссылку на предыдущую страницу
        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 1) . "'>&lt;</a></li>";
        }

        //формируем ссылку на следующую страницу
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 1) . "'>&gt;</a></li>";
        }

        //формируем ссылку на первую страницу
        if ($this->currentPage > 3) {
            $startpage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=1'>&laquo;</a></li>";
        }

        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=($this->countPages)'>&raquo;</a></li>";
        }

        if ($this->currentPage - 2 > 0) {
            $page2left = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 2) . "'>" . ($this->currentPage - 2) . "</a></li>";
        }

        if ($this->currentPage - 1 > 0) {
            $page1left = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 1) . "'>" . ($this->currentPage - 1) . "</a></li>";
        }

        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 1) . "'>" . ($this->currentPage + 1) . "</a></li>";
        }

        if ($this->currentPage + 2 < $this->countPages) {
            $page2right = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 2) . "'>" . ($this->currentPage + 2) . "</a></li>";
        }

        return '<ul class="pagination">' .
            $startpage .
            $back .
            $page2left .
            $page1left .
            "<li class='page-item'><a class='page-link active'>" . $this->currentPage . '</a></li>' .
            $page1right .
            $page2right .
            $forward .
            $endpage .
            '</ul>';
    }

    /**
     * Округление в большую сторону, либо единица
     * @return false|float|int
     */
    public function getCountPages()
    {
        return ceil($this->total / $this->perpage) ? : 1;
    }

    /**
     * Метод возвращает текущую страницу
     * Поскольку $page берётся из $_GET, производим проверки
     * @param $page
     * @return false|float|int
     */
    public function getCurrentPage($page)
    {
        if (!$page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    /**
     * Метод высчитвыает с какой записи необходимо отобразить страницу
     * @return float|int
     */
    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perpage;
    }

}