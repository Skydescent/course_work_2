<?php

namespace App\Validators;

use App\Helpers\SaveErrors;

class Validator
{
    use SaveErrors;

    /**
     * Массив с данными для валидации
     *
     * @var array
     */
    private $data;

    /**
     * Массив с правилами валидации
     *
     * @var array
     */
    private $rules = [];

    /**
     * Массив с именами полей, которые не нужно валидириовать
     *
     * @var array
     */
    private $rulesKeys = [];

    /**
     * Validator constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->initErrorsMsgs('valid_err_msgs');
    }

    /**
     * Валидирует данные из $data
     * в случае успеха возвращает true, неудачи false
     *
     * @return bool
     */
    public function validate()
    {
        $this->sanitizeSpecialChars();
        foreach ($this->rules as $method => $fieldRules) {
            foreach ($this->data as $fieldName => $value) {
                if (method_exists($this, $method)) {
                    if (!empty($this->rulesKeys) && !in_array($fieldName, $this->rulesKeys)) {
                        continue;
                    }
                    $this->$method($fieldName, $value);
                }
            }
        }
        if(count($this->errors) !== 0) {
            return false;
        }
        return true;
    }

    /**
     * Загружает правила валидации из переданного параметра $data
     *
     * @param $data
     */
    public function rules($data)
    {
        $this->rules = $data;
    }

    /**
     * Загружает массив с именами полей, которые не нужно валидировать
     *
     * @param $data
     */
    public function ruleKeys($data)
    {
        $this->rulesKeys = $data;
    }

    /**
     * Экранирует HTML-символы
     */
    protected function sanitizeSpecialChars()
    {
        $meth = 'sanitizeSpecialChars';
        foreach ($this->data as $fieldName => &$value) {
            if(($value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS)) === false) {
                $this->addErrorMsgByCat($meth, $fieldName);
            }
        }
    }

    /**
     * Проверяет заполненео ли поле
     *
     * @param $fieldName
     * @param $value
     */
    protected function required($fieldName, $value)
    {
        $meth = 'required';
        if (in_array($fieldName, $this->rules[$meth]) && strlen($value) === 0) {
            $this->addErrorMsgByCat($meth,$fieldName);
        }
    }

    /**
     * Фильтрует значение переданным фильтром
     *
     * @param $fieldName
     * @param $value
     */
    protected function filters ($fieldName, $value)
    {
        $meth = 'filters';
        if (
            array_key_exists($fieldName, $this->rules[$meth]) &&
            !filter_var($value, $this->rules[$meth][$fieldName]['filter'])
        ) {
            $this->addErrorMsgByCat($meth,$fieldName);
        }
    }

    /**
     * Проверяет минимальное количество символов в значении поля
     *
     * @param $fieldName
     * @param $value
     */
    protected function minLength($fieldName, $value)
    {
        $meth = 'minLength';
        if (array_key_exists($fieldName, $this->rules[$meth]) &&
            strlen($value) < $this->rules[$meth][$fieldName]
        ) {
            $this->addErrorMsgByCat($meth,$fieldName, [$this->rules[$meth][$fieldName]]);
        }
    }

    /**
     * Проверяет является ли переданное значение словом
     *
     * @param $fieldName
     * @param $value
     */
    protected function isWord($fieldName, $value)
    {
        $meth = 'isWord';
        if (in_array($fieldName, $this->rules[$meth]) && preg_match('#^[A-Za-zА-Яа-я]+[A-Za-zА-Яа-я \\s]*$#u', $value) === 0) {
            $this->addErrorMsgByCat($meth, $fieldName);
        }
    }

    /**
     * Проверяет равны ли значения полей
     *
     * @param $fieldName
     * @param $value
     */
    protected function equalFields($fieldName, $value)
    {
        $meth = 'equalFields';
        if (
            array_key_exists($fieldName, $this->rules[$meth]) &&
            $this->data[$this->rules[$meth][$fieldName]] !== $value
        ) {
            $this->addErrorMsgByCat($meth, $fieldName, [$this->rules[$meth][$fieldName]]);
        }
    }
}