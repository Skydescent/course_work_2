<?php

namespace App\View;

use App\Exception\NotFoundException;

use function helpers\includeView;

class View implements Renderable
{
    /**
     * Шаблон для отображения
     *
     * @var
     */
    private $layout;

    /**
     * Данные передаваемые шаблону
     *
     * @var mixed|null
     */
    private $options;

    /**
     * View constructor.
     *
     * @param $layout
     * @param null $options
     */
    public function __construct($layout, $options = NULL)
    {
        $this->layout = $layout;
        $this->options = $options;
    }

    /**
     * Подключает шаблон и передаёт данные для отображения
     * В случае если не существует шаблон - выбрасывает исключение
     *
     * @throws NotFoundException
     */
    public function render()
    {
        $pathTolayout = VIEW_DIR . implode('/',explode('.', $this->layout)) . '.php';
        if (!is_file($pathTolayout)) {
            throw new NotFoundException();
        }
        $header = VIEW_DIR . 'header.php';
        $footer = VIEW_DIR . 'footer.php';


        includeView($header);
        includeView($pathTolayout, $this->options);
        includeView($footer);

    }
}
