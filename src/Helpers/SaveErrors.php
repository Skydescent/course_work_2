<?php

namespace App\Helpers;

use App\Config;

trait SaveErrors
{
    /**
     * в свойство загружается массив с сообщениями об ошибках по типам ошибок
     * может инициализироваться из Config
     *
     * @var
     */
    protected $errorMsgs = [];

    /**
     * в свойство загружается массив с найденными ошибками, которые потом будут отображаться
     *
     * @var
     */
    protected $errors = [];

    /**
     * Загрузка массива с сообщениями об ошибках из Config
     *
     * @param $conf
     */
    protected function initErrorsMsgs($conf)
    {
        $config = Config::getInstance();
        $this->errorMsgs = $config->get($conf);
    }

    /**
     * Возвращает сообщения об ошибках
     *
     * @return mixed
     */
    public function getErrorsMsgs()
    {
        return $this->errorMsgs;
    }

    /**
     * Сохраняет сообщения об ошибке в массиве ошибок по категориям для отображения ошибок при валидации
     *
     * @param string $cat категория сообщений об ошибках
     * @param string $fieldName имя поля формы под которым нужно будет вывести ошибку
     * @param array $args в случае, если сообщение об ошибке это шаблон, то можно передать доп аргументы
     */
    protected function addErrorMsgByCat(string $cat, $fieldName = '', $args = [])
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

    /**
     * Добавляет массив с ошибками к массиву ошибок данного объекта
     *
     * @param array $errors
     */
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

    /**
     * Добавляет HTML всех ошибок в сессию
     */
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

    /**
     * Возвращает массив с ошибками
     *
     * @return array|false
     */
    public function errors()
    {
        if(count($this->errors) !== 0) {
            return $this->errors;
        }
        return false;
    }
}