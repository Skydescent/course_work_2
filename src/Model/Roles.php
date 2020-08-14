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

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
}