<?php

namespace App\Model;

class StaticPages extends Model
{
    /**
     * Не использовать автоматически поле временного штампа для таблицы БД
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Название таблицы БД
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [
        'id' => '',
        'alias' => '',
        'title' => '',
        'text' => '',
        'is_active' => '',
    ];

    /**
     * Массив с правилами валидации
     *
     * @var array
     */
    protected $rules = [
        'required' => [
            'title',
            'text',
            'alias',
        ],

        'minLength' => [
            'title' => 10,
            'text' => 100,
            'alias' => 3
        ],

    ];
}