<?php


namespace App\Model;


class Roles extends Model
{
    public $timestamps = false;
    protected $attributes = [
        'id' => '',
        'name' => ''
    ];
    protected $table = 'roles';
}