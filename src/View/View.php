<?php
namespace App\View;

use App\Exception\NotFoundException;

class View implements Renderable
{
    private $layout;
    private $options;

    public function __construct($layout, $options = NULL)
    {
        $this->layout = $layout;
        $this->options = $options;
    }

    public function render()
    {
        $pathTolayout = VIEW_DIR . implode('/',explode('.', $this->layout)) . '.php';
        if (!is_file($pathTolayout)) {
            throw new NotFoundException();
        }
        $header = VIEW_DIR . 'header.php';
        $footer = VIEW_DIR . 'footer.php';


        \helpers\includeView($header);
        \helpers\includeView($pathTolayout, $this->options);
        \helpers\includeView($footer);

    }
}
