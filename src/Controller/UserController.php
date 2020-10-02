<?php

namespace App\Controller;

use App\Exception\NoRightsException;
use App\Model\Subscribed;

use function helpers\h;
use function helpers\redirect;

class UserController extends \App\Controller
{
    /**
     * Получает и обрабатывает данные для отображения страницы авторизации пользователя.
     *
     * @return \App\View\View
     */
    public function login()
    {
        if (!empty($_POST)) {
            $user = new \App\Model\User();
            $data = h($_POST);

            $user->load($data);

            if ($user->login()) {
                Subscribed::addInfo($_SESSION['auth_subsystem']['email']);
                $_SESSION['success'] = 'Вы успешно вошли';
                redirect('/');
            } else {
                redirect();
            }

        }
        return $this->getView(__METHOD__);
    }

    /**
     * Получает и обрабатывает данные для отображения страницы регистрации пользователя.
     *
     * @return \App\View\View
     */
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
            unset($user->id);
            $user->role_id = 3;

            if ($user->save()) {
                $_SESSION['success'] = 'Вы успешно зарегистрированы';
                $user->password = '';
                $_SESSION['auth_subsystem'] = $user->getAttributes();
                Subscribed::addInfo($user->email);

                redirect('/');
            } else {
                $_SESSION['error']['page'] = 'Ошибка, попробуйте позже';
                redirect();
            }
        }
        return $this->getView(__METHOD__);
    }

    /**
     * Получает и обрабатывает данные для отображения страницы профиля пользователя.
     *
     * @return \App\View\View
     */
    public function profile()
    {
        if (!isset($_SESSION['error']) || empty($_SESSION['error'])) {
            $_SESSION['form_data'] = $_SESSION['auth_subsystem'];
        }

        if (!empty($_POST)) {
            $user = new \App\Model\User;
            $data = h($_POST);
            $user->load($_SESSION['auth_subsystem']);

            $updatedData = $user->checkAttrUpdates($data, ['login', 'email', 'about']);
            if ($data['password'] !== '' || $data['password_new'] !=='') {
                $updatedData['password'] = $data['password'];
                $updatedData['password_new'] = $data['password_new'];
                $isCorrectPassword = $user->isCorrectPassword($data['password']);
            } else {
                $isCorrectPassword = true;
            }
            $isFile = $_FILES['img']['size'] !== 0;

            if (count($updatedData) !== 0 || $isFile) {
                $oldLogin = $user->login;
                $oldEmail = $user->email;


                $fieldsToCheck = array_intersect_key($updatedData, ['login', 'email']);

                $file = $_FILES['img']['size'] !== 0 ? $user->uploadImg($_FILES['img'], 'img', $user->login) : null;

                if (
                    !$user->validate($updatedData) ||
                    !$user->checkUnique($fieldsToCheck) ||
                    $file === false ||
                    !$isCorrectPassword
                ) {
                    $user->getErrors();
                    $_SESSION['form_data'] = $data;
                    $_SESSION['form_data']['is_subscribed'] = $_SESSION['auth_subsystem']['is_subscribed'];
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
                }

                $user->load($updatedData);
                $user->updateUserData($updatedData, $oldLogin);

                if (isset($updatedData['email'])) {
                    $user->updateSubscribe($oldEmail);
                }
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

    /**
     * Получает и обрабатывает данные для выхода пользователя из ЛК.
     */
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