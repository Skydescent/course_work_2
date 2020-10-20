<?php
namespace helpers;

/**
 *Функция принимает массив и путь к опции в форме строки,
*
 * @param array $settings
 * @param string $fullKey
 * @return mixed
 */
function getSettingsId(array $settings, string $fullKey) {
    $id = null;
    $keyArray = explode('.', $fullKey);
    foreach ($keyArray as $key) {
        foreach ($settings as $setting) {
            if ($key == $setting['name'] && (is_null($id) || $id == $setting['parent_id'])) {
                $id = $setting['id'];
            }
        }
    }
    return $id;
}

/**
 *Функция принимает массив и опциоанльно имя поля,
 * рекурсивно вызывает сама себя и возвращает массив с настройками.
 *
 * @param array $settings
 * @param string|null $parentId
 * @return mixed
 */
function createArrayTree(array $settings, $parentId = null)
{
    $settingsArray = [];
    foreach ($settings as $row => $setting) {
        if ($setting['parent_id'] == $parentId) {
            $name =  $setting['name'];
            $id = $setting['id'];
            unset($settings[$row]);
            if (!in_array($id ,array_column($settings, 'parent_id'))) {
                if (!in_array($parentId ,array_column($settings, 'parent_id')) && count($settingsArray) == 0) {
                    return  $name;
                }
                $settingsArray[] = $name;
            } else {
                $settingsArray[$name] = createArrayTree($settings, $id);
            }
        }
    }
    return $settingsArray;
}

/**
*Функция принимает массив и многоуровневый ключ с точками,
* возвращает значение ключа вложенного в массив с массивами.
*
* @param array $array - массив c искомым значением
* @param string $key - многоуровневый ключ с точками
* @param $default - значение возвращаемое в случае если ключа не было найдено
* @return значение ключа
*/
function arrayGet(array $array, string $key, $default = null)
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
*
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
 *
 * @param string $postText
 * @return string
 */
function makeShortAnnotation(string $postText) : string
{
    return substr($postText, 0, SHORT_POST_TEXT) . '...';
}

/**
 * Форматирует дату
 *
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
 *
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


/**
 * Выводит данные на экран
 *
 * @param $arr
 */
function debug($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';

}

/**
 * Функия возращает строку с экранированными html
 * символами включая кавычки
 *
 * @param $data
 * @return array
 */
function htmlSecure($data)
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


/**
 * Добавляет текстовую приставку в зависимости от размера файла
 *
 * @param $size
 * @return string
 */
function humanBytes($size) {
    $fileSizeName = [" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"];
    return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $fileSizeName[$i] : '0 Bytes';
}
