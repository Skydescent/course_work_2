<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;

class Subscribed extends Model
{
    /**
     * Не использовать автоматически поле временного штампа для таблицы БД
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Атрибуты модели(поля таблицы БД)
     *
     * @var array
     */
    protected $attributes = [
        'email' => '',
        'is_active' => ''
    ];

    /**
     * Название таблицы БД
     *
     * @var string
     */
    protected $table = 'subscribed';

    /**
     * Добавляет email в таблицу БД subscribed
     * возвращает в случае успеха true, в случае неудачи false
     *
     * @return bool
     */
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

    /**
     * Удаляет email в таблицу БД subscribed
     * возвращает в случае успеха true, в случае неудачи false
     *
     * @return bool
     */
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

    /**
     * Добавляет(подписывает)/удаляет(отписывает) email в таблицу БД subscribed
     * в зависимости от того подписан он или отписан
     * в случае успеха возвращает true, неудачи false
     *
     * @return bool
     */
    public function toggle()
    {
        if ($this->isSubscribed()) {
            $result = $this->unsubscribe();
        } else {
            $result = $this->subscribe();
        }
        return $result;
    }

    /**
     * Изменяет email в таблице БД на новый
     *
     * @param $newEmail
     * @return bool
     */
    public function changeMail($newEmail)
    {
        $updateRows = self::query()
            ->where('email', '=', $this->email)
            ->update(['email' => $newEmail]);
        if ($updateRows === 0) {
            $_SESSION['error']['page'] = 'Ошибка обновления почты в подписке, попробуйте позже';
            return false;
        }
        return true;
    }

    /**
     * Возвращает коллекцию всех подписанных
     *
     * @return Subscribed[]|Collection
     */
    public function getAll()
    {
        return self::all();
    }

    /**
     * Добавляет в сессию пользователя подписан он или нет
     *
     * @param $email
     */
    public static function addInfo($email)
    {
        $sub = new self;
        $sub->load(['email' => $email]);
        if ($sub->isSubscribed()) {
            $_SESSION['auth_subsystem']['is_subscribed'] = 'yes';
        } else {
            $_SESSION['auth_subsystem']['is_subscribed'] = 'no';
        }
    }

    /**
     * Возвращает true если email подписан, если нет false
     *
     * @return bool
     */
    protected function isSubscribed()
    {
        return parent::getDbUnit('email') !== false;
    }
}