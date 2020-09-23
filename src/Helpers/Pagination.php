<?php


namespace App\Helpers;


use App\Config;
use function helpers\h;

class Pagination
{
    public $currentPage;
    public $perpage;
    public $total;
    public $countPages;
    public $uri;
    public $selects = null;
    public $selDefault;
    public $isSelect;

    /**
     * Pagination constructor.
     * @param $page текущая
     * @param $perpage количество страниц из настроек
     * @param $currentPage текущая страница
     * @param $total общее количество записей
     */
    public function __construct($currentPage, $total, $uri, bool $isSelect = false)
    {
        $this->initialize();
        $this->currentPage = $currentPage;
        $this->perpage = $this->setPerPage() ? $this->setPerPage() : $this->selDefault;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->uri = $uri;
        $this->isSelect = $isSelect;
    }

    public function initialize()
    {
            $configs = Config::getInstance();
            $this->selects = $configs->get('pagination.selects');
            $this->selDefault = $configs->get('pagination.selects.default');
    }


    /**
     * Метод при попытке вывода объекта выводит
     * HTML объекта
     * @return mixed
     */
    public function __toString()
    {
        $html = $this->isSelect ? $this->getSelectHtml($this->selects,$this->uri, 'get') : '';

        if ($this->countPages > 1) {
            $html .= $this->getHtml();
        }

        return $html;
    }

    public function getSelectHtml(array $select, $action, $method)
    {
        $selectHtml = '';
        foreach ($select as $option) {
            $value = $option == $this->perpage ? 'selected' : "value='$option'";
            $selectHtml .= "<option $value>$option</option>";
        }

        $selectHtml = "<form class='form-inline' action='$action' method='$method'>
                            <div class='form-group mx-sm-2 mb-2'>
                                <select class='form-control form-control-sm' name='sel_pagination'>
                                    $selectHtml
                                </select>
                            </div>
                            <button type='submit' class='btn btn-secondary btn-sm mb-2'>Применить</button>
                       </form>";
        return $selectHtml;
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
        $perPageLink = $this->isSelect ? "&sel_pagination=$this->perpage" : '';


        //формируем ссылку на предыдущую страницу
        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 1) . $perPageLink . "'>&lt;</a></li>";
        }

        //формируем ссылку на следующую страницу
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 1) . $perPageLink . "'>&gt;</a></li>";
        }

        //формируем ссылку на первую страницу
        if ($this->currentPage > 3) {
            $startpage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=1$perPageLink'>&laquo;</a></li>";
        }

        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=($this->countPages)$perPageLink'>&raquo;</a></li>";
        }

        if ($this->currentPage - 2 > 0) {
            $page2left = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 2) . $perPageLink . "'>" . ($this->currentPage - 2) . "</a></li>";
        }

        if ($this->currentPage - 1 > 0) {
            $page1left = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage - 1) . $perPageLink . "'>" . ($this->currentPage - 1) . "</a></li>";
        }

        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 1) . $perPageLink . "'>" . ($this->currentPage + 1) . "</a></li>";
        }

        if ($this->currentPage + 2 < $this->countPages) {
            $page2right = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=" .
                ($this->currentPage + 2) . $perPageLink . "'>" . ($this->currentPage + 2) . "</a></li>";
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

    public function getPerPage()
    {
        return $this->perpage;
    }

    /**
     * Метод присваивает свойству perPage значенеи из GET параметра или
     * @return bool|int
     */
    protected function setPerPage()
    {
        if (isset($_GET['sel_pagination'])) {
            return  (int) h($_GET['sel_pagination']);
        } else {
            return false;
        }
    }

}