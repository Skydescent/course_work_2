<?php
namespace App;

use App\View;
use App\Model;

abstract class Controller
{

    protected function getLayoutName($method)
    {
        return explode('::', $method)[1];
    }

    protected function getView($method =  NULL, $options = NULL)
    {
        $layout = is_null($method) ? DEFAULT_LAYOUT : $this->getLayoutName($method);
        $path = explode('Controller', ltrim(get_class($this), 'App\Controller\\'))[0];
        $layout = $layout ?? DEFAULT_LAYOUT;
        $layout = $path . '.' . $layout;
        return new View\View($layout, $options);
    }

    protected function getSubsInfo($email)
    {
        $sub = new Model\Subscribed();
        //$sub = new Subscribed();
        $sub->load(['email' => $email]);
        $sub->addInfo();
    }
}
