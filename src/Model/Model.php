<?php

namespace App\Model;

use App\Helpers;
use App\Validators;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Helpers\SaveErrors;

    /**
     * Имя таблицы в БД
     *
     * @var string
     */
    protected $table;

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Массив с правилами валидации
     *
     * @var array
     */
    protected $rules = [];


    /**
     * Перегружает свойства, для возможности использования методов Eloquent/Model
     *
     * @param $name
     * @return false|mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return false;
    }

    /**
     * Загружает атрибуты в модель
     *
     * @param array|string $data
     * @return Model|void
     */
    public function load($data)
    {
        foreach ($this->attributes as $name => $value)
        {
            if(isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    /**
     * Валидирует атрибуты согласно правилам модели
     *
     * @param null $data опционально можно валидировать передаваемые данные
     * @param null $ruleKeys опционально можно загружать другие правила
     * @return bool
     */
    public function validate($data = null, $ruleKeys = null)
    {
        $data = $data ?? $this->getAttributes();
        $validator = new Validators\Validator($data);
        if (!is_null($ruleKeys)) {
            $validator->ruleKeys($ruleKeys);
        }
        $validator->rules($this->rules);

        if ($validator->validate())
        {
            return true;
        }
        $this->addErrors($validator->errors());
        return false;
    }

    /**
     * Проверка отмечено ли поле
     *
     * @param $data
     * @param $filedName
     * @return bool
     */
    public function isChecked($data, $filedName)
    {
        $errMsg = 'Вы не отметили данное поле!';
        if(!isset($data[$filedName])) {
            $this->addErrors([$filedName => [$errMsg]]);
            return false;
        }
        return true;
    }

    /**
     * Возвращает атрибуты модели
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Проверяет какие атрибуты изменились
     *
     * @param array $data изменённые атрибуты
     * @param array $fields имена атрибутов по которым происходит проверка
     * @return array
     */
    public function checkAttrUpdates(array $data, array $fields)
    {
        $newData = [];
        foreach ($data as $name => $value) {
            if (in_array($name, $fields) && $this->getAttributes()[$name] !== $value) {
                $newData[$name] = $value;
            }

        }
        return $newData;
    }

    /**
     * Загружает файл и возвращает путь к файлу
     *
     * @param $file
     * @param $fieldName
     * @param $fileType
     * @param $prefixName
     * @return false|string|null
     */
    public function uploadFile($file, $fieldName, $fileType, $prefixName)
    {
        $uploader = new Helpers\Uploader($file, $fieldName, $fileType, $prefixName);
        if ($uploader->upload()) {
            return $uploader->getUploadedFilePath();
        }
        $this->addErrors($uploader->errors());
        return false;
    }

    /**
     * Удаляет файл изображения, если он существует
     */
    public function deleteImg()
    {
        if(file_exists(ROOT . $this->img)) {
            unlink(ROOT . $this->img);
        }
    }

    /**
     * Проверяет уникальность записи(модлели) в таблице БД
     *
     * @param $fieldNames
     * @return bool
     */
    public function checkUnique($fieldNames)
    {
        $isUnique = true;
        foreach ($fieldNames as $field) {
            $unit = $this->getDbUnit($field);
            if ($unit !== false) {
                    $error = [$field => ["Этот $field уже занят"]];
                    $this->addErrors($error);
                    $isUnique = false;
            }
        }
        return $isUnique;
    }

    /**
     * Получает объект модели по названию атрибута
     *
     * @param $field
     * @param $valueToCheck
     * @return false
     */
    protected function getDbUnit($field)
    {
        $unit = self::whereRaw(
            "$field = ?",
            [
                $this->attributes[$field]
            ]
        )
            ->first();
        if ($unit) {
            return $unit;
        }
        return false;
    }
}