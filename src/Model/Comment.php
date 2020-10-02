<?php

namespace App\Model;

class Comment extends Model
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
        'text' => '',
        'post_id' => '',
        'author_id' => '',
        'is_applied' => '',
        'created_at' => ''
    ];
    /**
     * Название таблицы БД
     *
     * @var string
     */
    protected $table = 'comments';

}