<?php


namespace App\Model;


class Subscribed extends Model
{
    public $timestamps = false;
    protected $attributes = [
        'email' => ''
    ];
    protected $table = 'subscribed';

    public function subscribe()
    {
        if (!$this->checkUnique(['email'])) {
            return false;
        }

        if (!$this->save()) {
            $error = ['is_subscribed' => ["Подписаться не получилось, попробуйте позже!"]];
            $this->addErrors($error);
            return false;
        }
        return true;
    }

    public function unsubscribe()
    {
        $deletedRows = self::query()
            ->where('email', $this->email)
            ->delete();
        if ($deletedRows === 0) {
            $error = ['is_subscribed' => ["Отписаться не получилось, попробуйте позже!"]];
            $this->addErrors($error);
            return false;
        }
        return true;
    }

    public function toggle()
    {
        if ($this->isSubscribed()) {
            $result = $this->unsubscribe();
        } else {
            $result = $this->subscribe();
        }
        return $result;
    }

    public function changeMail($newEmail)
    {
        $updateRows = self::query()
            ->where('login', $this->email)
            ->update(['email' => $newEmail]);
        if ($updateRows === 0) {
            $_SESSION['error']['page'] = 'Ошибка обновления, попробуйте позже';
            return false;
        }
        return true;
    }

    public function getAll()
    {
        return self::all();
    }

    public static function addInfo($email)
    {
        $sub = new self;
        $sub->load($email);
        if ($sub->isSubscribed()) {
            $_SESSION['auth_subsystem']['is_subscribed'] = 'yes';
        } else {
            $_SESSION['auth_subsystem']['is_subscribed'] = 'no';
        }
    }

    protected function isSubscribed()
    {
        return parent::getDbUnit('email') !== false;
    }
}