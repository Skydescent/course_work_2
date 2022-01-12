<?php


namespace App\Model;


use function helpers\arrayGet;
use function helpers\createArrayTree;
use function helpers\getSettingsId;

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

    /**
     * Возвращает объект настройки с данными из БД
     *
     * @param string $settingName
     * @return Setting|null
     */
    public static function getDbSettingByFullName(string $settingName): ?Setting
    {
        return Setting::firstWhere('parent_id',getSettingsId(Setting::all()->toArray(), $settingName));
    }

}