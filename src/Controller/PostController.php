<?php

namespace App\Controller;

use App\Controller;
use App\Helpers\Sender;
use App\Model;

use App\View\View;
use function helpers\h;
use function helpers\redirect;

class PostController extends Controller
{
    /**
     * Получает и обрабатывает данные для отображения страницы со статьёй.
     *
     * @param string $id
     * @return View
     */
    public  function post(string $id)
    {
        $post = Model\PostsList::whereId($id)->where('is_active', '<>', '0')->first();
        if (is_null($post)) {
            $_SESSION['error']['page'] = 'Доступ к статье закрыт, либо она не существует';
            redirect();
        }
        $comments = Model\Comment::query()
            ->where('post_id', '=', $id)
            ->LeftJoin('users', 'author_id', '=', 'users.id')
            ->get();

        if (!empty($_POST)) {
            if (!isset($_SESSION['auth_subsystem'])) {
                $_SESSION['error']['page'] = 'Комментарий могут оставить только зарегистрированные пользователи, пожалуйста Авторизуйтесь или зарегистрируйтесь!';
                redirect();
            }

            $data = h($_POST);

            if ($data['text'] == '') {
                $_SESSION['error']['page'] = 'Пустой комментарий оставить нельзя!';
                redirect();
            }
            $data['post_id'] = $post->id;
            $data['author_id'] = $_SESSION['auth_subsystem']['id'];
            $data['is_applied'] = '0';
            $data['created_at'] = date('Y-m-d',time());
            $comment = new Model\Comment();
            $comment->load($data);
            unset($comment->id);
            if ($comment->save()) {
                $_SESSION['success'] = 'Комментарий добавлен';
                redirect();
            } else {
                $_SESSION['error']['page'] = 'Ошибка, попробуйте добавить комментарий позже';
                redirect();
            }

        }

        return $this->getView(__METHOD__, ['post'=> $post, 'comments' => $comments]);
    }

    /**
     * Получает и обрабатывает данные для отображения формы добавления новой статьи.
     *
     * @return View
     */
    public function new()
    {
        if (!empty($_POST) && isset($_POST['add_post'])) {
            $post = new Model\PostsList();
            $data = h($_POST);

            $file = $_FILES['img']['size'] !== 0 ? $post->uploadFile($_FILES['img'], 'img', 'img', $post->login) : null;

            if (
                !$post->validate($data) ||
                $file === false
            ) {
                $post->getErrors();
                $_SESSION['form_data'] = h($data);
                redirect();
            }

            if ($file !== null) {
                if ($post->img !== '') {
                    $post->deleteImg();
                }
                $data['img'] = $file;
            }
            $data['user_id'] = $_SESSION['auth_subsystem']['id'];
            $data['created_at'] = date("Y-m-d");
            $data['is_active'] = 1;
            $post->load($data);
            $post->save();
            $_SESSION['success'] = 'Статья успешно добавлена';

            $sender = new Sender($post->title, $post->text, BASE_URL . "/post/$post->id");
            $sender->send();

            redirect('/');


        }
        return $this->getView(__METHOD__);
    }

}