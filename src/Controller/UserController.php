<?php


namespace App\Controller;


use App\Exception\NoRightsException;

use function helpers\h;
use function helpers\redirect;

class UserController extends \App\Controller
{
    public function login()
    {
        if (!empty($_POST)) {
            $user = new \App\Model\User();
            $data = h($_POST);

            $user->load($data);

            if ($user->login()) {
                $this->getSubsInfo($_SESSION['auth_subsystem']['email']);
                $_SESSION['success'] = 'Вы успешно вошли';
                redirect('/');
            } else {
                $_SESSION['error']['page'] = 'Логин или пароль введены неверно';
                redirect();
            }

        }
        return $this->getView(__METHOD__);
    }

    public function signup()
    {
        if (!empty($_POST)) {
            $user = new \App\Model\User();
            $data = h($_POST);
            $user->load($data);
            if (
                !$user->validate($data) ||
                !$user->checkUnique() ||
                !$user->isChecked($data, 'is_apply_rules')
            ) {
                $user->getErrors();
                redirect();
            }
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);

            if ($user->save()) {
                $_SESSION['success'] = 'Вы успешно зарегистрированы';
                $user->password = '';
                $_SESSION['auth_subsystem'] = $user->getAttributes();
                $this->getSubsInfo($user->email);

                redirect('/');
            } else {
                $_SESSION['error']['page'] = 'Ошибка, попробуйте позже';
                redirect();
            }
        }
        return $this->getView(__METHOD__);
    }

    public function profile()
    {
        if (!isset($_SESSION['auth_subsystem'])) {
            throw new NoRightsException();
        }

        if (!isset($_SESSION['error']) || empty($_SESSION['error'])) {
            $_SESSION['form_data'] = $_SESSION['auth_subsystem'];
        }

        if (!empty($_POST)) {
            $user = new \App\Model\User;
            $data = h($_POST);
            $user->load($_SESSION['auth_subsystem']);
            $updatedData = $user->checkAttrUpdates($data);

            if (count($updatedData) !== 0 || $_FILES['img']['size'] !== 0) {
                $oldLogin = $user->login;
                $user->load($updatedData);
                $checkUnique = [];
                foreach (['login', 'email'] as $field) {
                    if (key_exists($field, $updatedData)) {
                        $checkUnique[] = $field;
                    }
                }
                if (isset($updatedData['password']) || isset($updatedData['password_new'])) {
                    $isCorrectPassword = $user->isCorrectPassword($updatedData['password']);
                } else {
                    $isCorrectPassword = true;
                }

                $file = $_FILES['img']['size'] !== 0 ? $user->uploadImg($_FILES['img'], 'img', $user->name) : null;

                if (
                    !$user->validate($updatedData) ||
                    !$user->checkUnique($checkUnique) ||
                    $file === false ||
                    !$isCorrectPassword
                ) {
                    $user->getErrors();
                    $_SESSION['form_data'] = h($data);
                    redirect();
                }

                if (isset($updatedData['password_new']) && !empty($updatedData['password_new'])) {
                    $updatedData['password'] = password_hash($updatedData['password_new'], PASSWORD_DEFAULT);
                    unset($updatedData['password_new']);
                }

                if ($file !== null) {
                    if ($user->img !== '') {
                        $user->deleteImg();
                    }
                    $updatedData['img'] = $file;
                    $user->img = $file;
                }

                $user->updateUserData($updatedData, $oldLogin);
            }

            if (isset($data['is_subscribed'])) {
                if (!$user->toggleSubs()) {
                    $user->getErrors();
                    $_SESSION['form_data'] = h($data);
                } else {
                    $_SESSION['auth_subsystem']['is_subscribed'] = $_SESSION['auth_subsystem']['is_subscribed'] == 'no' ? 'yes' : 'no';
                }
            }
            redirect();
        }
        return $this->getView(__METHOD__);
    }

    public function logout()
    {
        if(isset($_SESSION['auth_subsystem'])) {
            unset($_SESSION['auth_subsystem']);
            if (isset($_SESSION['form_data'])) {
                unset($_SESSION['form_data']);
            }
            redirect('/');
        }
    }
}