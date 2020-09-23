<?php
namespace helpers;

/**
*Функция принимает массив и многоуровневый ключ с точками,
* возвращает значение ключа вложенного в массив с массивами.
* @param array $array - массив c искомым значением
* @param string $key - многоуровневый ключ с точками
* @param $default - значение возвращаемое в случае если ключа не было найдено
* @return значение ключа
*/
function array_get(array $array, string $key, $default = null)
{
    $keys = explode('.', $key);
    foreach ($keys as $shortKey) {
        if (array_key_exists($shortKey, $array)) {
            if (!next($keys)) {
                return $array[$shortKey];
            }
            if (gettype($array[$shortKey]) === 'array') {
                $array = $array[$shortKey];
            } else {
                return $array[$shortKey];
            }
        } else {
            return $default;
        }
    }
}

/**
*Функция добавляет шаблон и передаёт данные для него
* @param string $layout - путь к шаблону
* @param $data - данные для шаблона
 * @return void
*/
function includeView(string $layout, $data = null)
{
    require $layout;
}


/**
 * Укорачивает пост до количества знаков SHORT_POST_TEXT
 * @param string $postText
 * @return string
 */
function makeShortAnnotation(string $postText) : string
{
    return substr($postText, 0, SHORT_POST_TEXT) . '...';
}

/**
 * @param string $timeStr
 * @return bool
 */
function mainPostDateFormat(string $timeStr)
{
    return date(POST_DATE_FORMAT, strtotime($timeStr));
}

/**
 * Функция перенаправляет по указанному $http, если его нет то
 * по HTTP_REFERER или на главную
 * @param bool $http
 */
function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header("Location:$redirect");
    die;
}

function debug($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';

}

/**
 * Функия возращает строку с экранированными html
 * символами включая кавычки
 * @param $str
 * @return
 */
function h($data)
{
    if (gettype($data) == 'string') {
        return htmlspecialchars($data, ENT_QUOTES);
    }
    if (gettype($data) == 'array') {
        foreach ($data as $key => &$value) {
            $data[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        return $data;
    }

}
