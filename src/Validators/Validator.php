<?php

namespace App\Validators;


class Validator
{
    use \App\Helpers\SaveErrors;

    private $data = [];
    private $rules = [];
    private $rulesKeys = [];

    /**
     * Validator constructor.
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->initErrorsMsgs('valid_err_msgs');
    }

    public function validate()
    {
        $this->sanitizeSpecialChars($this->data);
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

    public function rules($data)
    {
        $this->rules = $data;
    }

    public function ruleKeys($data)
    {
        $this->rulesKeys = $data;
    }

    protected function sanitizeSpecialChars()
    {
        $meth = 'sanitizeSpecialChars';
        foreach ($this->data as $fieldName => &$value) {
            if(($value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS)) === false) {
                $this->addErrorMsgByCat($meth, $fieldName);
            }
        }
    }

    protected function required($fieldName, $value)
    {
        $meth = 'required';
        if (in_array($fieldName, $this->rules[$meth]) && strlen($value) === 0) {
            $this->addErrorMsgByCat($meth,$fieldName);
        }
    }

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

    protected function minLength($fieldName, $value)
    {
        $meth = 'minLength';
        if (array_key_exists($fieldName, $this->rules[$meth]) &&
            strlen($value) < $this->rules[$meth][$fieldName]
        ) {
            $this->addErrorMsgByCat($meth,$fieldName, [$this->rules[$meth][$fieldName]]);
        }
    }

    protected function isWord($fieldName, $value)
    {
        $meth = 'isWord';
        if (in_array($fieldName, $this->rules[$meth]) && preg_match('#^[A-Za-zА-Яа-я]+[A-Za-zА-Яа-я \\s]*$#u', $value) === 0) {
            $this->addErrorMsgByCat($meth, $fieldName);
        }
    }

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