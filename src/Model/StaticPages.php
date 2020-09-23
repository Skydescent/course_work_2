<?php


namespace App\Model;


class StaticPages extends Model
{
    public $timestamps = false;
    protected $table = 'pages';
    protected $attributes = [
        'id' => '',
        'alias' => '',
        'title' => '',
        'text' => '',
        'is_active' => '',
    ];
}