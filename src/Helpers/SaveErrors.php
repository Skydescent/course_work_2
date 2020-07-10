<?php


namespace App\Helpers;


trait SaveErrors
{
    /**
     * в свойство загружается массив
     * с сообщениями об ошибках, инициализуется из Config
     * @var
     */
    protected $errorMsgs = [];

    /**
     * в свойство загружается массив
     * с сообщениями об ошибках, инициализуется из Config
     * @var
     */
    protected $errors = [];

    /**
     * Метод загрузки массива с сообщениями об ошибках из Config
     * @param $config
     */
    protected function initErrorsMsgs($conf)
    {
        $config = \App\Config::getInstance();
        $this->errorMsgs = $config->get($conf);
    }

    /**
     * Функция возвращает сообщения об ошибках
     * @return mixed
     */
    public function getErrorsMsgs()
    {
        return $this->errorMsgs;
    }

    /**
     * Функция сохранения сообщения об ошибке в массиве ошибок
     * @param $cat категория сообщений об ошибках
     * @param string $fieldName имя поля формы под которым нужно будет вывести ошибку
     * @param array $args в случае, если сообщение об ошибке это шаблон, то можно передать доп аргументы
     */
    protected function addErrorMsgByCat($cat, $fieldName = '', $args = [])
    {
        if ($fieldName !== '') {
            if (count($args) > 0) {
                array_unshift($args, $fieldName);
            } else {
                $args = [$fieldName];
            }
            $this->errors[$fieldName][] = vsprintf($this->errorMsgs[$cat], $args);
        } else {
            $this->errors[$fieldName][] = $this->errorMsgs[$cat];
        }
    }

    protected function addErrors(array $errors)
    {
        foreach ($errors as $fieldName => $errMsgs) {
            if (key_exists($fieldName, $this->errors)) {
                $this->errors[$fieldName] = array_merge($this->errors[$fieldName], $errMsgs);
            } else {
                $this->errors[$fieldName] = $errMsgs;
            }
        }
    }

    public function getErrors()
    {

        foreach ($this->errors as $fieldName => $errMsgs) {
            $errors = '';
            foreach ($errMsgs as $msg) {
                $errors .= "<li>$msg</li>";
            }
            $_SESSION['error'][$fieldName] = "<ul>$errors</ul>";
        }
    }

    public function errors()
    {
        if(count($this->errors) !== 0) {
            return $this->errors;
        }
        return false;
    }
}