<?php

namespace App\Helpers;

use App\Config;

use function helpers\h;

class Pagination
{
    /**
     * Текущая страница
     *
     * @var int
     */
    public $currentPage;

    /**
     * Количество строк на одной странице
     *
     * @var int
     */
    public $perPage;

    /**
     * Общее количество строк
     *
     * @var int
     */
    public $total;

    /**
     * Количество страниц
     *
     * @var float|int
     */
    public $countPages;

    /**
     * URI для формирования ссылки на страницы
     *
     * @var
     */
    public $uri;

    /**
     * Массив с вариантами количества строк на странице, инициализируется из Config
     * По умолчанию не отображается, null
     *
     * @var null|array
     */
    public $selects = null;

    /**
     * Количество строк отображаемое на странице по умолчанию, инициализируется из Config
     *
     * @var
     */
    public $selDefault;

    /**
     * Отображать либо нет select с вариантами количества строк на страницу
     * По умолчанию нет
     *
     * @var bool
     */
    public $isSelect;

    /**
     * Pagination constructor.
     * @param $currentPage
     * @param $total
     * @param $uri
     * @param bool $isSelect
     */
    public function __construct($currentPage, $total, $uri, bool $isSelect = false)
    {
        $this->isSelect = $isSelect;
        $this->initialize();
        $this->currentPage = $currentPage;
        $this->perPage = $this->setPerPage() ? $this->setPerPage() : $this->selDefault;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->uri = $uri;

    }

    /**
     * Устанавливает количество строк на странице по умолчанию из настроек
     * В случае если необходим вывод селекта с количествами строк на странице
     * устанавливает их из Config
     */
    public function initialize()
    {
            $configs = Config::getInstance();
            if ($this->isSelect) {
                $this->selects = $configs->get('pagination.selects');
            }
            $this->selDefault = $configs->get('pagination.selects.default');
    }


    /**
     * Метод при попытке вывода объекта выводит HTML объекта
     *
     * @return string
     */
    public function __toString()
    {
        $html = $this->isSelect ? $this->getSelectHtml($this->selects,$this->uri, 'get') : '';

        if ($this->countPages > 1) {
            $html .= $this->getHtml();
        }

        return $html;
    }

    /**
     * Возвращает HTML селекта варианта количества строк на странице
     *
     * @param array $select
     * @param $action
     * @param $method
     * @return string
     */
    public function getSelectHtml(array $select, $action, $method)
    {
        $selectHtml = '';
        foreach ($select as $option) {
            $value = $option == $this->perPage ? 'selected' : "value='$option'";
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

    /**
     * Возвращает HTML пагинации
     *
     * @return string
     */
    public function getHtml()
    {
        $back = null;
        $forward = null;
        $startPage = null;
        $endPage = null;
        $page2left = null;
        $page1left = null;
        $page2right = null;
        $page1right = null;
        $perPageLink = $this->isSelect ? "&sel_pagination=$this->perPage" : '';


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
            $startPage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=1$perPageLink'>&laquo;</a></li>";
        }

        if ($this->currentPage < ($this->countPages - 2)) {
            $endPage = "<li class='page-item'><a class='page-link' href='{$this->uri}?page=($this->countPages)$perPageLink'>&raquo;</a></li>";
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
            $startPage .
            $back .
            $page2left .
            $page1left .
            "<li class='page-item'><a class='page-link active'>" . $this->currentPage . '</a></li>' .
            $page1right .
            $page2right .
            $forward .
            $endPage .
            '</ul>';
    }

    /**
     * Возвращает номер количества страниц
     *
     * @return float|int
     */
    public function getCountPages()
    {
        return ceil($this->total / $this->perPage) ? : 1;
    }

    /**
     * Возвращает номер текущей страницы
     *
     * @param $page
     * @return float|int
     */
    public function getCurrentPage($page)
    {
        if (!$page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    /**
     * Возвращает с какой записи необходимо отобразить страницу
     *
     * @return float|int
     */
    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Возвращает количество строк на странице
     *
     * @return bool|int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Возвращает значение количества строк из GET параметра или false
     *
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