<?php

namespace App\Model;

class Role extends Model
{
    /**
     * Не использовать автоматически поле временного штампа для таблицы БД
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [
        'id' => '',
        'name' => ''
    ];

    /**
     * Название таблицы БД
     *
     * @var string
     */
    protected $table = 'roles';
}