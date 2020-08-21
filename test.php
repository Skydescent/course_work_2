<?php

//class Controller
//{
//    public function sayYourName()
//    {
//        return __CLASS__;
//    }
//}
//
//$tst = new Controller();
//var_dump(explode('Controller', $tst->sayYourName())[0]);

$str = 'App\Controller\AdminController';
$newStr = str_replace(['App\Controller\\', 'Controller'], ['',''], $str);
$strPos = strpos($str,'App\Controller\\');
var_dump($newStr);

//$congfigs = require 'configs/file.php';
//$fileTypes = \helpers\array_get($congfigs, 'fileTypes.img');

//var_dump($_SERVER);
//var_dump($fileTypes);
//var_dump(dirname(__DIR__));
//var_dump(dirname(__FILE__));

//function run($uri, $path)
//{
//    preg_match(getPattern($path), $uri, $matches);
//    array_shift($matches);
//
//    if (count($matches) > 0) {
//        return call_user_func_array($this->getCallback(), array_values($matches));
//    } else {
//        return ($this->getCallback())();
//    }
//}

//var_dump(getPattern('/page/*'));
//$rules = [
//    'required' => [
//        'login',
//        'email',
//        'password',
//        'name',
//    ],
//    'filters' => [
//        'email' => [
//            'filter' => FILTER_VALIDATE_EMAIL
//        ]
//    ],
//
//    'minLength' => [
//        'password' => 8
//    ],
//    'isWord' => [
//        'name'
//    ],
//];
//$arr = [
//    'email' => 'kirill310587mail.ru',
//    'name' => 'Kirill331',
//    'login' =>'',
//    'password' => '453627'
//];
//$data = [
//    'login' => 'Miha',
//    'email' => 'mih@mail.ru',
//    'name' => 'Михаил',
//    'password' => '',
//    'password_conf' => '',
//];
//
//$attrs = [
//    'login' => 'Miha',
//    'email' => 'mih@gmail.com',
//    'name' => 'Михаил'
//];
//var_dump($data['login']);
//
//function check($data, $attrs){
//    $newData = [];
//    foreach ($data as $key => $value) {
//
//
//        if (
//            ($key == 'password' || $key == 'password_conf') &&
//            $data[$key] === ''
//        ) {
//            echo $key;
//            continue;
//        }
//
//        if ($attrs[$key] !== $value) {
//            $newData[$key] = $data[$key];
//        }
//        var_dump($key);
//
//    }
//    return $newData;
//}
//
//echo '<pre>';
//var_dump(check($data, $attrs));
//echo '</pre>';
//foreach ($arr as $name => &$value) {
//
//    $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
//
//    if (in_array($name, $rules['required']) && strlen($value) === 0) {
//        $errors[] = "Поле $name не заполнено!";
//    }
//    if (array_key_exists($name, $rules['filters']) && !filter_var($value, $rules['filters'][$name]['filter'])) {
//        $errors[] = "Некорректное значение поля $name";
//    }
//
//    if (array_key_exists($name, $rules['minLength']) && strlen($value) < $rules['minLength'][$name]) {
//        $errors[] = "Поле $name должно содержать {$rules['minLength'][$name]} символов";
//    }
//}
//echo '<pre>';
//if (count($errors) == 0) {
//    echo 'Результат:';
//    var_dump($arr);
//} else {
//    echo 'Ошибки:';
//    var_dump($errors);
//}
//echo '</pre>';

//var_dump(preg_match('#^[A-Za-z]+[A-Za-z \\s]*$#','Kirill'));
//var_dump(filter_var('', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

//echo vsprintf('Здесь должно быть слово: %s, а здесь число %d', ['Hello!', 593]);
