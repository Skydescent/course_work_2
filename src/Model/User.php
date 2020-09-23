<?php


namespace App\Model;


use Illuminate\Support\Facades\DB as DB;
use function helpers\debug;
use function helpers\redirect;

class User extends Model
{
    public $timestamps = false;
    protected $table = 'users';

    protected $attributes = [
        'id' => '',
        'login' => '',
        'password' => '',
        'email' => '',
        'role_id' => '',
        'img' =>'',
        'about' => '',
        'is_active' => ''
    ];

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

    public function checkUnique($fieldNames = ['login', 'email'])
    {
        return parent::checkUnique($fieldNames);
    }

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

    public function updateAttrs($data)
    {
        foreach ($data as $name => $value) {
            if (isset($this->$name)) {
                $this->$name = $value;
            }
        }
        $this->save();
    }

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

    public  function uploadImg($file, $fieldName, $prefixName)
    {
            return parent::uploadFile($file, $fieldName, 'img', $prefixName);
    }

    public function deleteImg()
    {
        unlink(ROOT . $this->img);
    }

    public function updateUserData ($data, $login = null)
    {
        if ($login === null) {
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

    public function toggleSubs()
    {
        $subs = new Subscribed();
        $subs->load(['email' => $this->email]);
        if ($subs->toggle()) {
            return true;
        }
        $this->addErrors($subs->errors());
        return false;
    }

    public function subscribe()
    {
        $subs = new Subscribed();
        $subs->load(['email' => $this->email]);
        if ($subs->subscribe()) {
            return true;
        }
        $this->addErrors($subs->errors());
        return false;
    }

    public function role()
    {
        return $this->belongsTo('App\Model\Role');
    }

    protected function getDbUser($field = 'login')
    {
        $user = parent::getDbUnit($field);
        if($user) {
            $role = \App\Model\Role::find($user->role_id);
            unset($user->original['role_id']);
            $user->original['role'] = $role->name;
        }
        return $user;
    }

}