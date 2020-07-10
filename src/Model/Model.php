<?php


namespace App\Model;


use App\Helpers;
use App\Validators;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Helpers\SaveErrors;

    protected $table;
    protected $attributes = [];
    protected $rules = [];

    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return false;
    }

    public function load($data)
    {
        foreach ($this->attributes as $name => $value)
        {
            if(isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

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

    public function isChecked($data, $filedName)
    {
        $errMsg = 'Вы не отметили данное поле!';
        if(!isset($data[$filedName])) {
            $this->addErrors([$filedName => [$errMsg]]);
            return false;
        }
        return true;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function checkAttrUpdates($data)
    {
        $newData = [];
        foreach ($data as $name => $value) {
            if (
                $name == 'is_subscribed' ||
                $name == 'id' ||
                $name == 'img' ||
                ($name == 'password' || $name == 'password_new') &&
                $data[$name] === ''
            ) {
                continue;
            }

            if (isset($this->attributes[$name]) && $this->attributes[$name] !== $value) {
                $newData[$name] = $data[$name];
            }
            if (!isset($this->attributes[$name])) {
                $newData[$name] = $data[$name];
            }

        }
        return $newData;
    }

    public function uploadFile($file, $fieldName, $fileTypes)
    {
        $uploader = new Helpers\Uploader($file, $fieldName, $fileTypes);
        if ($uploader->upload()) {
            return $uploader->getUploadedFilePath();
        }
        $this->addErrors($uploader->errors());
        return false;
    }

    public function checkUnique($fieldNames)
    {
        $isUnique = true;
        foreach ($fieldNames as $field) {
            $unit = $this->getDbUnit($field);
            if ($unit !== false) {
                if ($unit->$field = $this->attributes[$field]) {
                    $error = [$field => ["Этот $field уже занят"]];
                    $this->addErrors($error);
                    $isUnique = false;
                }
            }
        }
        return $isUnique;
    }

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