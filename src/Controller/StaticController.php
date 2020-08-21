<?php


namespace App\Controller;


class StaticController extends \App\Controller
{
    public function rules()
    {
        return $this->getView(__METHOD__);
    }
}