<?php


namespace App\Model;


class Role extends Model
{
    public $timestamps = false;
    protected $attributes = [
        'id' => '',
        'name' => ''
    ];
    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }
}