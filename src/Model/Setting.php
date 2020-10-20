<?php


namespace App\Model;


class Setting extends Model
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
    protected $table = 'settings';

}