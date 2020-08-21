<?php
namespace App;

use App\View;
use App\Model;
use function helpers\h;

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
}
