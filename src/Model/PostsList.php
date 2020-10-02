<?php
namespace App\Model;

class PostsList extends Model
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
    protected $table = 'posts';

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [
        'user_id' => '',
        'created_at' => '',
        'img' => '',
        'title' => '',
        'text' =>'',
        'is_active' => ''
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
        ],

        'minLength' => [
            'title' => 10,
            'text' => 100
        ],
    ];
}