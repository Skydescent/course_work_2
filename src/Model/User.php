<?php

namespace App\Model;

class User extends Model
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
    protected $table = 'users';

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [
        'id' => '',
        'login' => '',
        'password' => '',
        'email' => '',
        'role_id' => '',
        'role' => '',
        'img' =>'',
        'about' => '',
        'is_active' => '',
        'is_subscribed' => ''
    ];

    /**
     * Массив с правилами валидации
     *
     * @var array
     */
    protected $rules = [
        'required' => [
            'login',
            'email',
            'password',
        ],
        'filters' => [
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL
            ]
        ],

        'minLength' => [
            'password' => 6,
            'password_new' => 6
        ],
        'isWord' => [
            'name'
        ],
        'equalFields' => [
            'password_conf' => 'password'
        ]

    ];

    /**
     * Проверяет уникальность пользователя по полям переданным в массиве
     *
     * @param array $fieldNames
     * @return bool
     */
    public function checkUnique($fieldNames = ['login', 'email'])
    {
        return parent::checkUnique($fieldNames);
    }

    /**
     * Авторизация пользователя
     *
     * @return bool
     */
    public function login()
    {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if ($login && $password) {
            $user = $this->getDbUser();
            if ($user !== false) {
                if (password_verify($password, $user->password)) {
                    if($user->is_active !== 1) {
                        $_SESSION['error']['page'] = 'Ваша учётная запись Деактивирована, обратитесь к администрации сайта';
                        return false;
                    }
                    foreach ($user->original as $k => $v) {
                        if ($k != 'password') {
                            $_SESSION['auth_subsystem'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        $_SESSION['error']['page'] = 'Логин или пароль введены неверно';
        return false;
    }

    /**
     * Проверяет правильность пароля
     *
     * @param $password
     * @return bool
     */
    public function isCorrectPassword($password)
    {
        $user = $this->getDbUser();
        if ($user !== false) {
            if (password_verify($password, $user->password)) {
                return true;
            }
        }
        $errMsg = 'Пароль не верный!';
        $this->addErrors(['password' => [$errMsg]]);
        return false;
    }

    /**
     * Загружает изображение
     *
     * @param $file
     * @param $fieldName
     * @param $prefixName
     * @return false|string|null
     */
    public  function uploadImg($file, $fieldName, $prefixName)
    {
            return parent::uploadFile($file, $fieldName, 'img', $prefixName);
    }

    /**
     * Удаляет файл изображения, если он существует
     */
    public function deleteImg()
    {
        if(file_exists($this->img)) {
            unlink(ROOT . $this->img);
        }
    }

    /**
     * Обновляет поля пользователя в БД и в сессии
     *
     * @param $data
     * @param null $login
     */
    public function updateUserData ($data, $login = null)
    {
        if (is_null($login)) {
            $login = $this->login;
        }
        $updateRows = self::query()
            ->where('login', $login)
            ->update($data);
        if ($updateRows !== 0) {
            $_SESSION['success'] = 'Данные успешно обновлены';
            $_SESSION['auth_subsystem'] = $this->getAttributes();
            Subscribed::addInfo($this->email);
            $_SESSION['auth_subsystem']['password'] = '';
        } else {
            $_SESSION['error']['page'] = 'Ошибка обновления, попробуйте позже';
        }
    }

    /**
     * Добавляет(подписывает)/удаляет(отписывает) email пользователя в таблицу БД subscribed
     * в зависимости от того подписан он или отписан
     * в случае успеха возвращает true, неудачи false
     *
     * @return bool
     */
    public function toggleSubs()
    {
        $subs = new Subscribed();
        $subs->load(['email' => $this->email, 'is_active' => 1]);
        if ($subs->toggle()) {
            return true;
        }
        $this->addErrors($subs->errors());
        return false;
    }

    /**
     * Добавляет(подписывает) email пользователя,
     * в случае успеха возвращает true, неудачи false
     *
     * @return bool
     */
    public function subscribe()
    {
        $subs = new Subscribed();
        $subs->load(['email' => $this->email, 'is_active' => 1]);
        if ($subs->subscribe()) {
            return true;
        }
        $this->addErrors($subs->errors());
        return false;
    }

    /**
     * Обновляет электронную почту в таблице БД subscribed
     *
     * @param $oldEmail
     */
    public function updateSubscribe($oldEmail)
    {
        $subs = new Subscribed();
        $subs->load(['email' => $oldEmail]);
        $subs->changeMail($this->email);
    }

    /**
     * Возвращает объект пользователя с данными из БД
     *
     * @param string $field
     * @return false
     */
    protected function getDbUser($field = 'login')
    {
        $user = parent::getDbUnit($field);
        if($user) {
            $role = Role::find($user->role_id);
            unset($user->original['role_id']);
            $user->original['role'] = $role->name;
        }
        return $user;
    }

}